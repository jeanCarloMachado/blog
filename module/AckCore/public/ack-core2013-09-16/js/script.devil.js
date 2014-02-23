/**
 * funções genéricas para trabalhar com o ack (Devil version :)
 *
 * conveniências:
 * à nomenclatura do sistema deve ser o mais unificada o  possível por isso necessita-se de um
 * local para declará-la.
 *
 * Todas as chamadas devem direcitionar para algumLugar + "/routerAjax" (o router ajax irá tratar de sanitizar as entradas e direcionar para o local correto)
 *
 * utilizar o conceito de acl: recurso ação
 * lista de ações: add, view
 * lista de recursos: table, tableEntry
 * estes devem ser separados por (_) underline
 * preferencialmente utilizar os nomes dos elmentos para identificá-los
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
//###################################################################################
//################################# constantes do sistema ###########################################
//###################################################################################
var DEBUG = true;
//###################################################################################
//################################# END constantes do sistema ########################################
//###################################################################################
//###################################################################################
//################################# funções genéricas ###########################################
//###################################################################################
function foreach(array, func)
{
	for(var i = 0; i < array.length; i++) {
		func(array[i]);
	}
}
function foreachObj(array, func)
{
	for(var i = 0; i < array.length; i++) {
		func(array.next());
	}
}
/**
 * notifica um evento
 * @param  {[type]} evt [description]
 * @return {[type]}     [description]
 */
function notify(evt)
{
	if(DEBUG)
		console.log(evt);
}

function escapeRegExp(str) {
  return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
}

function getInstanceFromStr(str)
{
	return eval("new "+str);
}
//###################################################################################
//################################# END funções genéricas ########################################
//###################################################################################
//###################################################################################
//################################# funçẽos membro de classes  e classes ###########################################
//###################################################################################

function DataMiner() {
	var elements = new Array("input","textarea","select");

	this.seekFromParent = function (parent) {
		elements = parent.find("input,textarea,select");
		if(!elements) notify("Não encontrou nenhum elemento filho do tipo desejado");

		var data ={};
		elements.each(function() {
			data[$(this).attr("name")] = $(this).attr("value");
		});
		return data;
	}
}
function Url() {
	this.base = function () {
		return window.siteURL;
	}

	this.toUrl = function (url) {
		url =  url.toLowerCase();
		url =  url.replace("-","");
		url =  url.replace("_","");
		return url;
	}
	var currentController = $('input#infoPagina').data('info').arquivoRetorno;
}
/**
 * gerencia tabelas automáticas no ack
 */
function TableManager ()
{
	/**
	 * contém as entradas já adicionadas
	 * @type {String}
	 */
	var tableContainerClass = "parent_tableEntrys";
	var includeContainerClass = "parent_add_tableEntry";
	var relatedModel = "\\ElefranAck\\Model\\ProductTags";

	this.addEntry = function()
	{
		miner = new DataMiner;
		data = miner.seekFromParent($("."+includeContainerClass));
		data["model"]  = (relatedModel);
		ajaxMgr = new AjaxManager();
		ajaxMgr.url = "/ack/servicesprovider/routerAjax";
		ajaxMgr.action = "add_tableEntry";
		ajaxMgr.send(data);
	}

	this.editEntry = function (parentNode)
	{
		miner = new DataMiner;
		data = miner.seekFromParent(parentNode);
		data["model"]  = (relatedModel);
		ajaxMgr = new AjaxManager();
		ajaxMgr.url = "/ack/servicesprovider/routerAjax";
		ajaxMgr.action = "edit_tableEntry";
		ajaxMgr.send(data);
	}

	this.removeEntry = function (parentNode)
	{
		miner = new DataMiner;
		data = miner.seekFromParent(parentNode);
		data["model"]  = (relatedModel);
		ajaxMgr = new AjaxManager();
		ajaxMgr.url = "/ack/servicesprovider/routerAjax";
		ajaxMgr.action = "remove_tableEntry";
		ajaxMgr.send(data);
	}

	this.construct = function ()
	{
		instance = this;
		entrys = document.getElementsByClassName("add_tableEntry");
		foreach(entrys, function(entry) {
			entry.onclick = function() { instance.addEntry() };
		});
		//adiciona o editar
		entrys = $(".edit_tableEntry");
		foreachObj(entrys, function(entry) {
			entry.click(function() { instance.editEntry(entry.parent()) });
		});
		entrys = null;
		//adiciona o editar
		entrys = $(".remove_tableEntry");
		foreachObj(entrys, function(entry) {
			entry.click( function() { instance.removeEntry(entry.parent()) });
		});
	}
	this.construct();
}

function AjaxManager()
{
	var url;
	var action;
	/**
	 * realiza alguma açẽos antes de enviar o ajax
	 * @param  {[type]} data [description]
	 * @return {[type]}      [description]
	 */
	this.beforeSend = function (data) {
		url = new Url;
		this.url = url.base() + this.url;
		data['action'] = url.toUrl(this.action);
		data = JSON.stringify(data);
		return data;
	}
	/**
	 * envia dados por ajax
	 * @param  {[type]} data [description]
	 * @return {[type]}      [description]
	 */
	this.send = function (data)
	{
		data =  this.beforeSend(data);
		result = null;
		$.ajax({
			url:  this.url,
			type: 'POST',
			data: 'ajaxACK='+ data,
			dataType: 'json',
			success: function(data) {
				result = data;
			}
		})
		return result;
	}
}

function ServiceManager()
{
	var services = new Array("TableManager");
	this.initServices = function () {

		for(i=0;i<services.length;i++) {
			var service = services[i];
			instance =  getInstanceFromStr(service);
		}
	}
}
//###################################################################################
//################################# END funçẽos membro de classes ########################################
//###################################################################################
//###################################################################################
//################################# eventos ###########################################
//###################################################################################
/**
 * evento ligado ao bootrap da aplicaçãos
 * @return {[type]} [description]
 */
function onBootstrap()
{

	sm = new ServiceManager();
	sm.initServices();

}
//###################################################################################
//################################# END eventos ########################################
//###################################################################################
//###################################################################################
//################################# função main ###########################################
//###################################################################################
$(window).load(function()
{
     onBootstrap();
});
//###################################################################################
//################################# END função main ########################################
//###################################################################################



