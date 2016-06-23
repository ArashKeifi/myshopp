/* JCE Editor - 2.5.14 | 30 January 2016 | http://www.joomlacontenteditor.net | Copyright (C) 2006 - 2016 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
(function(){var DOM=tinymce.DOM,Event=tinymce.dom.Event,extend=tinymce.extend,each=tinymce.each,Cookie=tinymce.util.Cookie,explode=tinymce.explode;tinymce.create('tinymce.plugins.StyleSelectPlugin',{init:function(ed,url){var self=this;this.editor=ed;ed.onNodeChange.add(function(ed,cm){var c=cm.get('styleselect'),formatNames=[],matches;if(c){formatNames=[];each(c.items,function(item){formatNames.push(item.value);});matches=ed.formatter.matchAll(formatNames);c.select(matches[0]);tinymce.each(matches,function(match,index){if(index>0){c.mark(match);}});}});},createControl:function(n,cf){var ed=this.editor;switch(n){case"styleselect":if(ed.getParam('styleselect_stylesheet')!==false||ed.getParam('style_formats')||ed.getParam('theme_advanced_styles')){return this._createStyleSelect();}
break;}},_createStyleSelect:function(n){var self=this,ed=this.editor,ctrlMan=ed.controlManager,ctrl,PreviewCss=tinymce.util.PreviewCss;ctrl=ctrlMan.createListBox('styleselect',{title:'advanced.style_select',onselect:function(name){var matches,formatNames=[],removedFormat;each(ctrl.items,function(item){formatNames.push(item.value);});ed.focus();ed.undoManager.add();matches=ed.formatter.matchAll(formatNames);tinymce.each(matches,function(match){if(!name||match===name){if(match){ed.formatter.remove(match);}
removedFormat=true;}});if(!removedFormat){ed.formatter.apply(name);}
ed.undoManager.add();ed.nodeChanged();return false;}});ed.onPreInit.add(function(){var counter=0,formats=ed.getParam('style_formats'),styles=ed.getParam('theme_advanced_styles','','hash');if(formats){each(formats,function(fmt){var name,keys=0;each(fmt,function(){keys++;});if(keys>1){name=fmt.name=fmt.name||'style_'+(counter++);ed.formatter.register(name,fmt);ctrl.add(fmt.title,name,{style:function(){return new PreviewCss(ed,fmt);}});}else{ctrl.add(fmt.title);}});}
if(styles){each(styles,function(val,key){var name,fmt;if(val){name='style_'+(counter++);fmt={classes:val,selector:'*'};ed.formatter.register(name,fmt);ctrl.add(ed.translate(key),name,{style:function(){return new PreviewCss(ed,fmt);}});}});}});return ctrl;}});tinymce.PluginManager.add('styleselect',tinymce.plugins.StyleSelectPlugin);})();