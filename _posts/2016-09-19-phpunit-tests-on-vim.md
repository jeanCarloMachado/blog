---
layout: post
title: A smart way of testing inside Vim
---

Most of my developing time I pass on the test suite. More than that, I
spend the majority of time in a specific test file or even a single
test function. Given that, any effort made to simplify this process
is a good one. In this mood I'll present my method of testing while
developing inside Vim.

The following function wraps PHPunit's and allows me to run tests from inside vim and other goodies that I'll describe below.

```
function! RunPHPUnitTest(filter)
    cd %:p:h
    if a:filter

        normal! T yw
        if @" =~ "^test*"
            normal! mT
        endif

        normal! `T

        normal! T yw
        "
        let myCommand="phpunit -c ". $PWD ."/Backend/phpunit.xml.dist \ 
            --filter " . @" . " " . expand("%:p")
        let result = system(myCommand)
    else let @n = expand('%:t') 
        if @n =~ "Test"
            normal! mA
        endif
        normal! `A


        let myCommand = "phpunit -c ". $PWD . "/Backend/phpunit.xml.dist \
            " . expand("%:p")
        let result = system(myCommand)
    endif
    split __PHPUnit_Result__
    normal! ggdG
    setlocal buftype=nofile
    call append(0, myCommand)
    call append(0, split(result, '\v\n'))
    cd -
endfunction

```

With the following maps:

```
nnoremap <leader>u :call RunPHPUnitTest(0)<cr>
nnoremap <leader>f :call RunPHPUnitTest(1)<cr>

```

Now when I press ``<leader>u`` it runs the current file tests and prints the
result in a new split. And when I press ``<leader>f`` while over a test name
it runs the test and opens the same split on the current window.

Even better, once I played a test it keeps a mark of which one I
had run, so I don't have to be on the function or on the file to run
it again, simply ``<leader>(u|f)`` to get the same result.

To be honest, the original function is not a creation of mine. I
found it on the internet. But the mark thing is mine, so if It's
useful for you as well let me know :).
