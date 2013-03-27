(function() {
    tinymce.create('tinymce.plugins.qd_buttons', {
		 
        init : function(ed, url){
            ed.addButton('highlight', {
            title : 'Highlight',
                onclick : function() {
					
                    ed.focus();
					ed.selection.setContent(' [highlight] ' + ed.selection.getContent() + ' [/highlight] ');
                   
                },
             image:  url +  "/shortcodes/img/ed_highlight.png"
            });
			
			ed.addCommand('buttons', function() {
				ed.windowManager.open({
					file : url +  '/shortcodes/buttons.php'+qd_wpml_lang,
					width : 350,
					height : 540,
					inline : 1
				});
			
			});
						
			ed.addButton('buttons', {
            title : 'Insert Button',
               cmd : 'buttons',
               image:  url +  "/shortcodes/img/ed_buttons.png"
            });		
			
			ed.addButton('qd_table', {
            title : 'Table',
                onclick : function() {
					
                    ed.focus();
					ed.selection.setContent(' [qd_table] <table> <thead><tr><th>Header 1</th><th>Header 2</th></tr></thead> <tbody><tr><td>Division 1</td><td>Division 2</td></tr></tbody> </table> [/qd_table] ');
                   
                },
             image:  url +  "/shortcodes/img/ed_table.png"
            });
			
			ed.addCommand('contactForm', function() {
				ed.windowManager.open({
					file : url +  '/shortcodes/contactForm.php'+qd_wpml_lang,
					width : 900,
					height : 700,
					inline : 1
				});
			});
			ed.addButton('contactForm', {
            title : 'Insert Contact Form',
               cmd : 'contactForm',
               image:  url +  "/shortcodes/img/ed_contactForm.png"
            });
			
			ed.addButton('list', {
            title : 'Insert List',
                onclick : function() {
					
                    ed.focus();
					ed.selection.setContent(' [qd_list] <ul>	<li>Item #1</li>	<li>Item #2</li>	<li>Item #3</li></ul>[/qd_list] ');
                   
                },
             image:  url +  "/shortcodes/img/ed_list.png"
            });
						
			
			
			ed.addCommand('notifications', function() {
				ed.windowManager.open({
					file : url +  '/shortcodes/notifications.php'+qd_wpml_lang,
					width : 350,
					height : 330,
					inline : 1
				});
			
			});
						
			ed.addButton('notifications', {
            title : 'Insert Notification',
               cmd : 'notifications',
               image:  url +  "/shortcodes/img/ed_notifications.png"
            });	
			
			ed.addButton('divider', {
            title : 'Insert Separator line',
              image:  url +  "/shortcodes/img/ed_divider.png",
			  onclick : function() {
                ed.selection.setContent("<hr>");
            }
            });		
			
			
			ed.addButton('toggle', {
            title : 'Insert Toggle',
                  onclick : function() {
                    ed.focus();
					ed.selection.setContent('[toggle  title="Toggle title"]'+ ed.selection.getContent() +'[/toggle] ');
                   
                },
               image:  url +  "/shortcodes/img/ed_toggle.png"
            });		
			
			ed.addButton('tabs', {
            title : 'Insert Tabs',
                  onclick : function() {
                    ed.focus();
					ed.selection.setContent('[tabgroup] <br>[tab title="Tab 1"]'+ ed.selection.getContent() +'[/tab] <br>[tab title="Tab 2"]Tab 2 content goes here.[/tab] <br>[tab title="Tab 3"]Tab 3 content goes here.[/tab] <br>[/tabgroup]');
                   
                },
               image:  url +  "/shortcodes/img/ed_tabs.png"
            });		
			
			
			
			ed.addCommand('social_link', function() {
				ed.windowManager.open({
					file : url +  '/shortcodes/social_link.php'+qd_wpml_lang,
					width : 350,
					height : 470,
					inline : 1
				});
			
			});
			ed.addButton('social_link', {
            title : 'Insert Social Link',
               cmd : 'social_link',
               image:  url +  "/shortcodes/img/ed_social.png"
            });
			
			ed.addCommand('social_button', function() {
				ed.windowManager.open({				
					file : url +  '/shortcodes/social_button.php'+qd_wpml_lang,
					width : 350,
					height : 700,
					inline : 1
				});
			
			});
			ed.addButton('social_button', {
            title : 'Insert Share Button',
               cmd : 'social_button',
               image:  url +  "/shortcodes/img/ed_social_button.png"
            });	
			ed.addCommand('teaser', function() {
				ed.windowManager.open({
					file : url +  '/shortcodes/teaser.php'+qd_wpml_lang,
					width : 350,
					height : 550,
					inline : 1
				});
			
			});
			
			
        },
		createControl:function(d,e,url)
				{
				
					if(d=="columns"){
					
						d=e.createMenuButton( "columns",{
							title:"Insert Columns Shortcode",							
							icons:false							
							});
							
							var a=this;d.onRenderMenu.add(function(c,b){
								
								
								a.addImmediate(b,"Column 1/2", ' [one_half]  [/one_half] ');
								a.addImmediate(b,"Column 1/2 last", ' [one_half last=last]  [/one_half] ');
								a.addImmediate(b,"Column 1/3", ' [one_third]  [/one_third] ');
								a.addImmediate(b,"Column 1/3 last", ' [one_third last=last]  [/one_third] ');
								a.addImmediate(b,"Column 1/4", ' [one_fourth]  [/one_fourth] ');
								a.addImmediate(b,"Column 1/4 last", ' [one_fourth last=last]  [/one_fourth] ');
								a.addImmediate(b,"Column 2/3", ' [two_third]  [/two_third] ');
								a.addImmediate(b,"Column 2/3 last", ' [two_third last=last]  [/two_third] ');
								a.addImmediate(b,"Column 3/4", ' [three_fourth]  [/three_fourth] ');
								a.addImmediate(b,"Column 3/4 last", ' [three_fourth last=last]  [/three_fourth] ');								
								
								b.addSeparator();
								
								a.addImmediate(b,"Clear", '[clear]');
								
								b.addSeparator();
								
							
							});
						return d
					
					} // End IF Statement
					
					return null
				},
		
				addImmediate:function(d,e,a){d.add({title:e,onclick:function(){tinyMCE.activeEditor.execCommand( "mceInsertContent",false,a)}})}
    });

    tinymce.PluginManager.add('qd_buttons', tinymce.plugins.qd_buttons);
})();