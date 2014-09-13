<?php
/**
 * bloco de troca de senha
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
class PasswordManagementBlock extends ElementAbstract
{
  /**
     * campos requeridos para que o elemento renderize efetivamente
     * @var array
     */
    protected $userRow = null;

    public function defaultLayout()
    {
        $row = $this->getUserRow();

        if (!$row->getId()->getBruteVal()) {

            Input::Factory($row->getSenha())->setTitle('Nova senha')->setType('password')->render();
            Input::Factory($row->getSenha())->setTitle('Confirme sua senha')->setType('password')->render();

        } else {
            ?>
            <div>
            <?php
            Button::getInstance()->setId('alterarSenha')->setName('alterarSenha')->setTitle('Alterar Senha')->appendClass('btn')->appendClass('btn-default')->setPermission('+rw')->render();
            Button::getInstance()->setId('fecharAlterarSenha')->setName('fecharAlterarSenha')->setTitle('Cancelar')->appendClass('btn')->appendClass('btn-default')->setPermission('+rw')->render();
            ?>
            </div>
            <br/>
            <?php
            Input::Factory($row->getSenha())->setParentClasses('alterarSenhaElement')->setId('senha')->setTitle('Nova senha')->setValue('')->setType('password')->render();
            Input::Factory($row->getSenha())->setParentClasses('alterarSenhaElement')->setId('repetirSenha')->setTitle('Confirme sua senha')->setValue('')->setType('password')->render();
        }
       ?>
            <script>
                $(document).ready(function () {
                        $('.alterarSenhaElement').hide();
                        $('#fecharAlterarSenha').hide();
                        $('#alterarSenha').click(function () {
                            $('.alterarSenhaElement').show();
                            $('#fecharAlterarSenha').show();
                            $(this).attr("disabled", "disabled");
                        });

                        $('#fecharAlterarSenha').click(function () {
                            $('.alterarSenhaElement').hide();
                            $('#fecharAlterarSenha').hide();
                            $('#alterarSenha').removeAttr("disabled");
                        });

                        $('#repetirSenha').blur(function () {
                            if($('#repetirSenha').val() != $('#senha').val())
                                alert('As senhas são incompatívies');
                        });
                });
            </script>
        <?php
    }

    public function getUserRow()
    {
        if (empty($userRow)) {

            $this->userRow = $this->getServiceLocator()->get('Usuarios')->getRowPrototype();
        }

        return $this->userRow;
    }

    public function setUserRow($userRow)
    {
        $this->userRow = $userRow;

        return $this;
    }
}
