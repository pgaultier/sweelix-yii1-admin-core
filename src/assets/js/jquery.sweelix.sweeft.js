/**
 * File jquery.sweelix.ajax.js
 *
 * This is a simple ajax helper
 *
 * @author    Philippe Gaultier <pgaultier@sweelix.net>
 * @copyright 2010-2014 Sweelix
 * @license   http://www.sweelix.net/license license
 * @version   2.0.0
 * @link      http://www.sweelix.net
 * @category  js
 * @package   sweelix.yii1.admin.core.assets.js
 */
(function($) {
	var module = {
		'id': 'sweeft',
		'major': 1,
		'minor': 0
	};
	
	var config = {
		'editor':'ckeditor'
	};
	
	jQuery.sweelix.registerModule(module);

	jQuery.extend(jQuery.sweelix, {
		'sweeft': {
			'init': function() {
				jQuery.extend(true, config, jQuery.sweelix.config(module.id));
				
				/**
				 * Declare the wysiwyg editor to handle "data" parameters
				 */
				jQuery.fn.wysiwyg = function (params) {
					params = (params || {});
					if(config.editor == 'cleditor') {
						jQuery.sweelix.info('jQuery(%s).wysiwyg()', this.selector);
						return this.each(function () {
							var data = jQuery(this).data('wysiwyg');
							var finalData = {};
							jQuery.extend(finalData, params, data);
							jQuery(this).cleditor(finalData);
						});
					} else if(config.editor == 'ckeditor') {
						jQuery.sweelix.info('jQuery(%s).wysiwyg()', this.selector);
						return this.each(function () {
							var data = jQuery(this).data('wysiwyg');
							var finalData = {};
							jQuery.extend(finalData, params, data);
							jQuery(this).ckeditor(function(){}, finalData);
						});
					}
				};
				
				/**
				 * showMessageBox
				 * @param object {'type':'info', 'message':'message to display', 'time':'3500'}
				 */
				jQuery.sweelix.register(
					'showMessageBox', 
					function(data){
						data = data || {};
						data = jQuery.extend({'title':'Information', 'type':'info', 'message':'', 'close':'Close', 'time':10000}, data) ;
						var title;
						if(typeof data.type !== 'string') {
							data.type = 'info';
						}
						switch(data.type) {
							case 'valid':
								title = 'Confirmation';
								break;
							case 'warning':
								title = 'Attention';
								break;
							case 'error':
								title = 'Error';
								break;
							default:
								title = 'Information';
								type = 'info';
								break;
						}
						data.type = 'absnotice '+data.type;
						var message = jQuery('<div class="'+data.type+'"><a title="'+data.close+'" class="close" href="javascript:void(0)">'+data.close+'</a><span class="info">'+title+'</span><p><strong>'+title+':</strong> '+data.message+'</p></div>');
						jQuery('body').append(message);
						setTimeout(function(){
							jQuery(message).find('a.close').click();
						}, data.time);
						jQuery("html:not(:animated),body:not(:animated)").animate({ scrollTop: jQuery(message).offset().top}, 500 );
					}
				);
				/**
				 * closeMessageBox
				 * @param object jquery element used to close the message box
				 */
				jQuery.sweelix.register(
					'closeMessageBox', 
					function(closeButton){
						$(closeButton).parent().animate({
							'height':0,
							'opacity':0,
							'margin-top':0, 'margin-bottom':0,
							'border':0,
							'padding-top':0, 'padding-bottom':0
						}, 'slow', function(){ $(this).remove();});
					}
				);

				jQuery.sweelix.info('sweelix.%s : attach event to infobox close button', module.id);
				jQuery('body').delegate('div.notice a.close, div.absnotice a.close', 'click', function(evt){
                        evt.preventDefault();
                        jQuery.sweelix.raise('closeMessageBox', this);
                });				

				if(typeof(jQuery.datepicker) != 'undefined') {
					jQuery.datepicker.setDefaults(jQuery.datepicker.regional['']);
					jQuery.datepicker.setDefaults(jQuery.datepicker.regional[config.language]);
				}
				jQuery.sweelix.info('sweelix.%s : init module version (%d.%d)', module.id, module.major, module.minor);
			}
		}
	});
})(jQuery);
