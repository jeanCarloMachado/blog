<?php
/**
 * container de relação com menu de busca
 *
 * PHP version 5
 *
 * LICENSE:  This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Jean Carlo Machado <j34nc4rl0@gmail.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 3
 * @copyright  Copyright (C) CUB
 * @link       http://www.icub.com.br
 */
namespace AckCore\HtmlElements;
class RelationWithSearch extends ElementAbstract
{
    public function defaultLayout()
    {
        ?>
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <span class="clearBoth"></span>
      <div class="modulo Products">
        <div class="head">
          <button class="btnAB"><em>Componentes do produto</em></button>
          <p>Nesta área, você pode selecionar os <strong>componentes</strong> relacionados ao produto acima.</p>
        </div><!-- END head -->

        <div class="slide">
          <div class="scrollLista scrollLista-busca">
            <span></span>

            <div>
              <div class="header">
                <h3>Componentes deste produto</h3>
              </div>

              <form class="scroll-busca" data-finder="componentes" data-finder-show="#componentes-resultado" data-finder-container="#componentes-lista">
                <label>
                  <input type="text" name="busca_categoria" autocomplete="off" placeholder="Digite aqui o que você procura" />
                </label>

                <div id="componentes-resultado"></div>
              </form>

              <fieldset class="lista checkGrup">
                <ul id="componentes-lista">
                  <?php for ($test=1; $test < 100; $test++) { ?>
                  <li id="<?php echo $test; ?>">
                    <label>
                      <input type="hidden" value="<?php echo $test; ?>" name="Products" />
                      <em>Produto 03</em> <button class="finder-remove">x</button>
                    </label>
                  </li>
                  <?php }; ?>
                </ul>
              </fieldset><!-- END lista -->
            </div>

            <span></span>
          </div><!-- END scrollLista -->
        </div>
      </div>
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////// -->
        <?php
    }

}
