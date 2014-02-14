	function SweeftUploader() {
		var uploader;
		var self;
		function cutName(fileName){
			var name = fileName;
			if (fileName.length > 24) {
				name = fileName.substr(0,12) + '...' + fileName.substr(fileName.length-12,fileName.length)
			}
			return name;
		}
		function getContainerId() {
			return uploader.getId()+'_list';
		}
		function getDropZoneId() {
			return uploader.getId()+'_zone';
		}
		function formatSize(size) {
			return uploader.formatSize(size)
		}
		function getDeleteUrl() {
			return uploader.getDeleteUrl();
		}
		function getPreviewUrl() {
			return uploader.getPreviewUrl();
		}
		function getConfig() {
			return uploader.getEventHandlerConfig();
		}
		this.Error = function(up, error) {
			sweelix.raise('showNotice', {
				'title' : '<span class="icon-bubble-exclamation light"></span> Erreur',
				'close' : '<span class="icon-circle-cancel light">x</span>',
				'text' : error.message,
				'cssClass' : 'danger'
			});
			switch(error.code) {
				case plupload.GENERIC_ERROR:
					break;
				case plupload.HTTP_ERROR:
					break;
				case plupload.GENERIC_ERROR:
					break;
				case plupload.IO_ERROR:
					break;
				case plupload.SECURITY_ERROR:
					break;
				case plupload.INIT_ERROR:
					break;
				case plupload.FILE_SIZE_ERROR:
					break;
				case plupload.FILE_EXTENSION_ERROR:
					break;
				case plupload.IMAGE_FORMAT_ERROR:
					break;
				case plupload.IMAGE_DIMENSIONS_ERROR:
					break;
				default:
					break;
			}
			
		}
		this.AsyncDelete = function(file, name){

		}
		this.FilesRemoved = function (up, files) {
			$.each(files,  function(i, file){ 
				$('#'+file.id).fadeOut('slow', function(){ $(this).remove(); });
			});
		};	
		this.UploadProgress = function (up, file) {
			$('#'+getContainerId()+' #'+file.id+' div.progress').css({width:file.percent+'%'});
		};
		
		this.PostInit = function(up) {
			uploader = up;
			var config = getConfig();
			var dropText = 'Drop files';
			if('dropZoneText' in config) {
				dropText = config['dropZoneText'];
			}
			$('#'+up.getId()).before('<div id="'+getDropZoneId()+'" class="dropZone" style="display:none">'+dropText+'</div>');
			$('#'+up.getId()).after('<ul id="'+getContainerId()+'" class="filesContainer"> </ul>');
		}
		this.FilesAdded = function (up, files) {
			$.each(files,  function(i, file){ 
				$('#'+getContainerId()).append('<li id="'+ file.id + '" class="fileContainer" title="'+file.name+'">' + cutName(file.name.replace('tmp://', '')) + ' ('+ formatSize(file.size) +')<div class="progressBar"><div class="progress"></div></div></li>');
			});
			// up.refresh();
		};
		this.FileUploaded = function (up, file, response) {
			var json = $.parseJSON(response.response); 
			var name = json.fileName;
			if(json.status == true) { 
				$('#'+getContainerId()+' #'+file.id+' div.progress').css({width:'100%'});
				var remove = $('<a href="#" class="close"><span class="icon-circle-cancel dark">X</span></a>');
				remove.one('click', function(evt){
					evt.preventDefault();
					self.AsyncDelete(file, name);
					uploader.removeFile(file, name);
				});
				remove.hover(
					function(evt){
						$(this).find('span').removeClass('dark').addClass('light');
					},
					function(evt){
						$(this).find('span').removeClass('light').addClass('dark');
					}
				);
				$('#'+getContainerId()+' #'+file.id).prepend(remove);
				$.ajax({
					'url' : getPreviewUrl(),
					'data' : {
						'fileName' : name,
						'mode' : 'json'
					}
				}).done(function(data){
					if(data.path != null) {
						var element = $('<a href="'+data.path+'" target="_blank"><img src="'+data.url+'" /></a>')
						var config = getConfig();
						if('linkClass' in config) {
							element.addClass(config['linkClass']);						
						}
						if('store' in config) {
							element.data('store', config['store'])
						}
						if(data.image == false) {
							element.after($('<br/><span>'+data.path+'</span>'));
						}
					} else {
						var element = $('<img src="'+data.url+'" />');
					}
					$('#'+getContainerId()+' #'+file.id).append(element);
				});
				
			} 
		};
		self = this;
		
	}
	
jQuery(document).ready(function(){
	function isValidDrag(e) {
		var dt = e.dataTransfer;
		// do not check dt.types.contains in webkit, because it crashes safari 4
		var isWebkit = navigator.userAgent.indexOf("AppleWebKit") > -1;

		// dt.effectAllowed is none in Safari 5
		// dt.types.contains check is for firefox
		return dt && dt.effectAllowed != 'none' && (dt.files || (!isWebkit && dt.types.contains && dt.types.contains('Files')));
	}
	function initDragEvent() {
		document.addEventListener('dragenter', function(e){
			if(!isValidDrag(e)) return;
			$('.dropZone').show();
		}, false);
		document.addEventListener('dragleave', function(e){
			if(!isValidDrag(e)) return;
            var relatedTarget = document.elementFromPoint(e.clientX, e.clientY);
            // only fire when leaving document out
            if ( ! relatedTarget || relatedTarget.nodeName == "HTML"){
            	$('.dropZone').hide();
            }
		}, false);
		$('body').on('dragenter', '.dropZone', function(e){
			if($(this).hasClass('hover') == false) {
				$(this).addClass('hover');
			}
		});
		$('body').on('dragover', '.dropZone', function(e){
			if($(this).hasClass('hover') == false) {
				$(this).addClass('hover');
			}
            var effect = e.originalEvent.dataTransfer.effectAllowed;
            if (effect == 'move' || effect == 'linkMove'){
            	e.originalEvent.dataTransfer.dropEffect = 'move'; // for FF (only move allowed)
            } else {
            	e.originalEvent.dataTransfer.dropEffect = 'copy'; // for Chrome
            }
		});
		$('body').on('dragleave', '.dropZone', function(e){
			if($(this).hasClass('hover') == true) {
				$(this).removeClass('hover');
			}
		});
		$('body').on('drop', '.dropZone', function(evt){
			$('.dropZone').hide().removeClass('hover');
		});
		
	}
	initDragEvent();
});
