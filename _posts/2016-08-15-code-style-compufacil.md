---
layout: post
title: Code Style on Compufacil
---

In Compufácil we have a set of style guides that must be
followed by the developer for the code to be accepted on the repository.
This rules help us to avoid common mistakes and make our code reviews
quicker. We enforce this rules through phpmd and phpcs plus some shell
scripting.

<script type="text/javascript"
src="https://asciinema.org/a/7zsuxbe8rhvy15ihe2jy19vw4.js"
id="asciicast-7zsuxbe8rhvy15ihe2jy19vw4" async></script>

To do what the video showed we simply called a script (cpf-code-checker) on each changed
PHP file in the current commit.

The hook is located at ```.git/hooks/pre-commit```. Is like the
following:

```
PHP_STAGED_FILES_CMD=`git diff --cached --name-only --diff-filter=ACMR HEAD | grep \\\\.php`
SFILES=${SFILES:-$PHP_STAGED_FILES_CMD}
for FILE in $SFILES; do
    echo "Cheking file $FILE"

    $CLIPP_PATH/Cli/cpf-code-check $FILE

    if [ $? != 0 ]; then
        echo "Fix file: $FILE"
        exit 1
    fi
done

```

The important part here is the command responsible for style
checking `cpf-code-check`, and when it returns failure the hole
command fails.


## Code Checker

The following is the definition of the checker.

```
#!/usr/bin/env bash
#cpf-code-check

excludePatterns=`cat $CLIPP_PATH/Backend/styleignore`

for i in $excludePatterns; do
    [[ $@ =~ $i ]] && {
        echo -e "\e[5m\e[31mIgnored pattern $i\e[0m"
        exit 0
    }
done

hasError=0

echo "Running phpcs"

$CLIPP_PATH/Backend/vendor/bin/phpcs  --standard=$CLIPP_PATH/Backend/ruleset.xml $@
csResult=$?
echo "CS Result: $csResult"

[[ $csResult != 0 ]] && {
    hasError=1
}

echo "-------"
echo "Running php-md"

$CLIPP_PATH/Backend/vendor/bin/phpmd  --minimumpriority 4 $@  text $CLIPP_PATH/Backend/phpmd.xml

mdResult=$?
echo "MD Result: $mdResult"

[[ $mdResult != 0 ]] && {
    hasError=1
}

echo "-------"
echo "Final Result: $hasError"

exit $hasError

```

We can ignore files with the ``styleignore`` file. This is useful for
some new syntax that appears in PHP like anonymous classes, that are
detected as errors by the checkers so are disabled for now.

```
Core.?Validator.?IsFloat.php
.*DataFacadeTest.*.php
Backend/module/Fiscal/tests/src/FiscalTest/Service/NFE/NFETest.php
NFE.+ConsumerTest
Backend/module/Application/src/Application/Service/.*.php
```

And the last part is our custom configurations of phpmd and phpcs.

## ruleset.xml

```
<?xml version="1.0"?>
<ruleset name="Compufacil">
 <exclude-pattern>*.config.php</exclude-pattern>
 <exclude-pattern>Bootstrap.php</exclude-pattern>
 <rule ref="PSR2">
  <exclude name="Generic.NamingConventions.CamelCapsFunctionName" />
  <exclude name="PSR1.Methods.CamelCapsMethodName" />
 </rule>
 <rule ref="Generic.NamingConventions.UpperCaseConstantName"/>
  <rule ref="Generic.Commenting.Todo"/>
  <rule ref="Squiz.Strings.DoubleQuoteUsage.ContainsVar"/>
 <rule ref="Generic.Files.LineLength">
  <properties>
   <property name="lineLimit" value="120"/>
   <property name="absoluteLineLimit" value="0"/>
  </properties>
 </rule>
</ruleset>
```

## phpmd.xml

```
<?xml version="1.0"?>
<ruleset xmlns="http://pmd.sf.net/ruleset/1.0.0"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://pmd.sf.net/ruleset/1.0.0 http://pmd.sf.net/ruleset_xml_schema.xsd"
         xsi:noNamespaceSchemaLocation=" http://pmd.sf.net/ruleset_xml_schema.xsd">

    <rule ref="rulesets/codesize.xml">
        <exclude name="TooManyMethods" />
        <exclude name="CyclomaticComplexity" />
        <exclude name="NPathComplexity" />
        <exclude name="ExcessiveClassComplexity" />
        <exclude name="TooManyPublicMethods" />
    </rule>
    <rule ref="rulesets/codesize.xml/TooManyMethods">
        <priority>5</priority>
        <properties>
            <property name="maxmethods" value="20" />
        </properties>
    </rule>

    <rule ref="rulesets/codesize.xml/TooManyPublicMethods">
        <priority>5</priority>
        <property name="maxmethods" description="The method count reporting threshold" value="15"/>
    </rule>

    <rule ref="rulesets/controversial.xml">
        <exclude name="CamelCaseVariableName" />
        <exclude name="CamelCaseMethodName" />
        <exclude name="CamelCaseParameterName" />
    </rule>

    <rule ref="rulesets/naming.xml">
        <exclude name="LongVariable" />
        <exclude name="ShortVariable" />
    </rule>

    <rule ref="rulesets/naming.xml/LongVariable">
        <priority>1</priority>
        <properties>
            <property name="maximum" value="30" />
        </properties>
    </rule>

    <rule ref="rulesets/naming.xml/ShortVariable">
        <properties>
            <property name="minimum" value="2"/>
        </properties>
    </rule>

    <rule ref="rulesets/design.xml/CouplingBetweenObjects">
        <priority>5</priority>
    </rule>
</ruleset>
```


Those configurations are very specific for our case but it's works
well as an skeleton for other projects.

That's it, if your find this checker useful let us know.

