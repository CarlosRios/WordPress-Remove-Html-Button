jQuery(document).ready(function($){
    tinymce.PluginManager.add('remove_html_button', function( editor, url ) {
        editor.addButton( 'remove_html_button', {
            text: 'Remove Html',
            icon: 'icon remove-html-button-icon',
            tooltip: 'Removes all the html in the selection',
            onclick: function() {
                //editor.insertContent('Hello World!');
                var content = editor.selection.getContent();
				$.ajax({
					type : 'post',
					url : remove_html_button.ajaxurl,
					data : { action: 'remove_html', content: content },
					success : function(data){
						editor.selection.setContent(data);
					}
				});
            }
        });
    });
});