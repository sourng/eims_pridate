;(function($) {  
    $.fn.Upload = function(option = false){	
        var listImage = $(this)
      , countImage = $('<div></div>')
      , pages = {
        init: ()=>{
            pages.load_field();
            countImage.addClass('pull-right');
            countImage.text('0/' + pages.files_limit);
            listImage.after(countImage);
            listImage.parent().css({
                border : '2px dashed transparent',
                position: 'relative'
            });   
            pages.save();
        }
        ,
        files_limit: option.files_limit ? option.files_limit : (listImage.attr('data-limit-image')),
        token: option._token ? option.token : (listImage.attr('data-token') ? listImage.attr('data-token') : $('meta[name="_token"]').attr('content')),
        upload_url: option.upload_url ? option.upload_url : (listImage.attr('data-upload-url')),
        rotate_url: option.rotate_url ? option.rotate_url : (listImage.attr('data-rotate-url')),
        delete_url: option.delete_url ? option.delete_url : (listImage.attr('data-delete-url')),
        allow_size: option.allow_size ? option.allow_size : (listImage.attr('data-allow-size')),
        allow_file: option.allow_file ? option.allow_file : (listImage.attr('data-allow-file') ? listImage.attr('data-allow-file') : 'image/jpeg,.jpg,image/gif,.gif,image/png,.png,.jpeg'),
        save_url: option.save_url ? option.save_url : (listImage.parents('form').attr('action')),
        load_field: function() {
            for (var i = 0; i < pages.files_limit; i++) {
                var file = $('<div></div>')
                  , browse = $('<div></div>')
                  , input = $('<input/>');
                file.addClass('file');
                file.attr({
                    id: 'file-' + i
                });
                browse.addClass('browse');
                input.attr({
                    title: '',
                    type: 'file',
                    multiple: true,
                    accept: pages.allow_file,
                });

                input.on('input', function(files) {
                    var self = $(this);
                    pages.files(files.target.files, self);
                    $(this).val('');

                });

                input.appendTo(browse);
                browse.appendTo(file);
                file.appendTo(listImage);
            }
            pages.imageDrop();
        },
        files: function(files, target, kind = 'file') {
            (function() {               
                if(kind === 'file'){
                    if (window.File && window.FileReader && window.FileList && window.Blob) {
                        if (files.length > pages.files_limit) {
                            return Swal.fire({
                                type: 'warning',
                                title: 'Oop!',
                                text: 'limit: ' + pages.files_limit + ' image',
                                showConfirmButton: true,
                            });
                        } else {
                            var e = listImage.find('[type="file"]')
                            , i = 0;
                            e.length && e.each(function() {
                                if ($(this).parent().find('.img').length > 0) {
                                    i++;
                                }
                            });

                            if ((i + files.length) > pages.files_limit) {
                                return Swal.fire({
                                    type: 'warning',
                                    title: 'Oop!',
                                    html: 'Limit: ' + pages.files_limit + ' image.<br>Need ' + (pages.files_limit - i) + ' more.',
                                    showConfirmButton: true,
                                });
                            }
                        }

                        return  pages.uploadImage(files, target);

                        var tmp = [];
                        for (var i = 0; i < files.length; i++) {
                            var file = files[i];
                            tmp.push({file:file});
                            var reader = new FileReader();
                            if (file.type.match('image.*')) {
                                reader.onload = (function(file) {
                                    return function(f) {

                                        if(file.size > pages.allow_size){
                                            return Swal.fire({
                                                type: 'warning',
                                                title: 'Oop!',
                                                html: 'File allow size : ' + pages.bytesToSize(pages.allow_size),
                                                showConfirmButton: true,
                                            });
                                        }else{
                                            var b64 = pages.b64toFile(f.target.result);
                                            //pages.uploadImage(b64, file.name, target);
                                        }                                   
                                    }
                                }
                                )(file);
                                reader.readAsDataURL(file);
                            }
                        }
                        pages.uploadImage(tmp, target);
                    }
                }else if(kind == 'string'){

                    var e = listImage.find('[type="file"]')
                    , i = 0;
                    e.length && e.each(function() {
                        if ($(this).parent().find('.img').length > 0) {
                            i++;
                        }
                    });
                    if ((i + 1) > pages.files_limit) {
                        return Swal.fire({
                            type: 'warning',
                            title: 'Oop!',
                            html: 'Limit: ' + pages.files_limit + ' image.<br>Need ' + (pages.files_limit - i) + ' more.',
                            showConfirmButton: true,
                        });
                    }
                    
                    
                    var xhr = new XMLHttpRequest(),
                        url = files;
                    if (!/^https?:\/\//i.test(url)) {
                        url = '//' + url;
                    }
                    xhr.open("GET", url);
                    xhr.responseType = "blob";
                    xhr.onload = function response(e) {
                      var reader = new FileReader();
                      var file = this.response;
                        reader.onload = (function(file) {
                            return function(f) {
                                if(file.size > pages.allow_size){
                                    return Swal.fire({
                                        type: 'warning',
                                        title: 'Oop!',
                                        html: 'File allow size : ' + pages.bytesToSize(pages.allow_size),
                                        showConfirmButton: true,
                                    });
                                }else{
                                  if(pages.allow_file.match((file.type).split('/').pop())){
                                    var name = ((file.type).split('/').pop() === 'html') ? 'image.svg' : (file.type).replace('/','.');
                                    var b64 = pages.b64toFile(f.target.result);
                                    pages.uploadImage(b64, target , 'link');
                                  }                                    
                                }                                
                            };
                        })(file);
                        reader.readAsDataURL(file);
                    };
                
                       
                    
                    xhr.send();
                }    
            })();
        },
        imageDrop: function() {
            $(document)
            .on('dragover', function(e) {  
                listImage.parent().css({
                    border : '2px dashed #75a3f5',
                });   
                if(listImage.parent().find('.drag-drop').length === 0){
                    listImage.parent().append('<div class="drag-drop"><div class="text">Drag Link/Files Here</div></div>');
                }                
               e.preventDefault();
            })
            .on('drop', function(e) { 
               listImage.parent().css({
                    border : '2px dashed transparent',
                });  
                listImage.parent().find('.drag-drop').remove();              
                e.preventDefault();
                return false; 
            })
            .on('dragleave', function(e) {
               listImage.parent().css({
                    border : '2px dashed transparent',
                });  
            });

            listImage.parent()
            .on('dragover',function(e){ 
                var drop = 'Drop Link/Files Here';
                var data = e.originalEvent.dataTransfer.items;
                    if (data[0].kind === 'file') {        
                        drop = 'Drop Files Here';
                    } else{ 
                        drop = 'Drop Link Here';                        
                    }      
                    listImage.parent().find('.drag-drop').children().html(drop);  
                e.preventDefault();
            }).on('dragleave',function(e){ 
                var drop = 'Drop Link/Files Here';               
                    listImage.parent().find('.drag-drop').children().html(drop);  
                e.preventDefault();
            }).on('drop',function(e){   
                var kind = e.originalEvent.dataTransfer.getData("text") ? 'string' : 'file';    
                    if(kind === 'file'){
                        pages.files(e.originalEvent.dataTransfer.files, $(this), kind);   
                    }else{
                        pages.files(e.originalEvent.dataTransfer.getData("text"), $(this), kind);   
                    }                     
                            
                listImage.parent().find('.drag-drop').remove();
                e.preventDefault();
            }).on('paste',function(e){
                pages.files(e.originalEvent.clipboardData.files, $(this));
            });
        },
        imageView : function(file_in_uploading = false, file = false) {
            if (file_in_uploading) {
                var imageContainer = $('<div></div>')
                  , btnRotate = $('<a href="javascript:(0);"></a>')
                  , btnDelete = $('<a href="javascript:(0);"></a>')
                  , view = $('<div></div>')
                  , image = $('<img/>');

                imageContainer.addClass('img');
                btnRotate.addClass('image_rotate');
                btnRotate.on('click', function(e) {
                    e.preventDefault();
                    var id = $(this).parent().find('.img-contain').attr('dataid');
                    pages.rotateImage(id, imageContainer);
                });

                btnDelete.addClass('image_delete');
                btnDelete.on('click', function(e) {
                    e.preventDefault();
                    var id = $(this).parent().find('.img-contain').attr('dataid');
                        listImage.find('.file#'+$(this).parent().attr('id')).find('.browse').removeClass('disabled');
                        pages.deleteImage(id, imageContainer)

                });
                view.addClass('img-view');
                image.addClass('img-contain');
                image.attr({
                    src: file ? file.path : '',
                    dataId: file ? file.name : '',

                });
                image.appendTo(view);
                btnRotate.appendTo(imageContainer);
                btnDelete.appendTo(imageContainer);
                view.appendTo(imageContainer);

                var e = listImage.find('[type="file"]'),
                    i = 1;
                e.length && e.each(function() {
                    if ($(this).parent().find('.img').length === 0) {
                        var id = $(this).parent().parent().attr('id')
                        imageContainer.attr({
                            id: id,
                        });

                        if (file) {
                            $(this).attr({
                                'data-files' : JSON.stringify(file)
                            }).after(imageContainer);
                    
                            $(this).parent().parent().removeClass('loading').find('.percent').remove();
                            listImage.find('.file#'+id).find('.browse').addClass('disabled');
                            
                            return false;
                        } else {
                            var percent = $('<div></div>');
                            percent.addClass('percent');

                            $(this).parent().parent().addClass('loading');
                            $(this).parent().parent().append(percent);
                            if(i === file_in_uploading) return false; 
                            i++;
                        }
                    }

                });

            }
        },
        uploadImage: function(files, target = false , from = 'input') {
           
            var formData = new FormData(),
                file_in_uploading = 0;
            formData.append('_token', pages.token);
            //formData.append('file', files);
            //formData.append('name', name);
            if(from == 'input'){
                for (var i = 0; i < files.length; i++) {
                    if( files[i].size > pages.allow_size){
                        // return Swal.fire({
                        //     type: 'warning',
                        //     title: 'Oop!',
                        //     html: 'File allow size : ' + pages.bytesToSize(pages.allow_size),
                        //     showConfirmButton: true,
                        // });
                     
                        continue;
                    }else{
                        formData.append('files[]', files[i]);
                        file_in_uploading++;
                    }                    
                }
            }else if(from == 'link'){
                formData.append('files[]', files);
                file_in_uploading++;
            }
           
            $.ajax({
                url: pages.upload_url,
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                xhr: function() {
                    var xhr = new XMLHttpRequest();
                    xhr.onprogress = function(e) {
                        // For downloads
                        if (e.lengthComputable) {// console.log(parseInt(e.loaded / e.total * 100) + '%');
                        }
                    }
                    ;
                    xhr.upload.onprogress = function(e) {
                        // For uploads
                        if (e.lengthComputable) {
                            pages.imageView(file_in_uploading);
                            var percent = target.parent().parent().find('.percent');
                            percent.width(parseInt(e.loaded / e.total * 100) + '%');

                        }
                    }
                    ;
                    return xhr;
                },
                success: function(response) {
                    if (response.success) {

                        $.each(response.files,function(i){                          
                            pages.imageView((i+1), this);
                        })

                        countImage.text(response.count + '/' + pages.files_limit);
                        
                    }
                },
                error: function(error) { 
                    var data = error.responseJSON;                  
                    return Swal.fire({
                        type: 'error',
                        title: 'Oop!',
                        html:  data.message,
                        showConfirmButton: true,
                    })
                }
            });
        },
        rotateImage: function(id, target=false) {
            var formData = new FormData();
            formData.append('_token', pages.token);
            formData.append('id', id);
            $.ajax({
                url: pages.rotate_url + id,
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        if (target) {
                            var rotate = target.parent().find('.img-contain').attr('data-rotate');
                            if (rotate === undefined) {
                                rotate = 1;
                            } else {
                                if (rotate > 3) {
                                    rotate = 0;
                                } else {
                                    rotate++;
                                }
                            }

                            switch (rotate) {
                            default:
                            case 0:
                                target.parent().find('.img-contain').attr('data-rotate', 0).css('transform', 'rotate(0deg)');
                                break;
                            case 1:
                                target.parent().find('.img-contain').attr('data-rotate', 1).css('transform', 'rotate(90deg)');
                                break;
                            case 2:
                                target.parent().find('.img-contain').attr('data-rotate', 2).css('transform', 'rotate(180deg)');
                                break;
                            case 3:
                                target.parent().find('.img-contain').attr('data-rotate', 3).css('transform', 'rotate(270deg)');
                                break;
                            }
                            ;
                        }
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        },
        deleteImage: function(id, target=false) {
            var formData = new FormData();
            formData.append('_token', pages.token);
            formData.append('id', id);
            $.ajax({
                url: pages.delete_url + id,
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        if (target) {
                            target.parent().parent().find('[data-files]').removeAttr('data-files');
                            target.remove();
                            countImage.text(response.count + '/' + pages.files_limit);
                        }
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        },

        b64toFile: function(dataURI) {           
            const byteString = atob(dataURI.split(',')[1]);
            const mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]
            const ab = new ArrayBuffer(byteString.length);
            const ia = new Uint8Array(ab);
            for (let i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            const blob = new Blob([ab],{
                'type': mimeString
            });
            blob['lastModifiedDate'] = (new Date()).toISOString();
            blob['name'] = 'file';
            switch (blob.type) {
            case 'image/jpeg':
                blob['name'] += '.jpg';
                break;
            case 'image/png':
                blob['name'] += '.png';
                break;
            }
            return blob;
        },
        bytesToSize:function(bytes) {
            var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            if (bytes == 0) return '0 Bytes';
            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
            return Math.round(bytes / Math.pow(1024, i), 2) + '' + sizes[i];
        },
        save : () =>{
          listImage.parents('form').on('submit',(e)=>{
            e.preventDefault();
            var formData = new FormData(e.target);               
            $.ajax({
                url: pages.save_url,
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend:function(){
                    listImage.parent().append('<div class="proccessing"><div class="image"></div>');
                    listImage.parents('form').find('[type="submit"]').attr('disabled','disabled');
                },
                success: function(response) {
                    if (response.success) {
                        var showContainer = $('<div></div>');
                                $.each(response.files,function(i,files){                              
                                    for(var file in files){
                                        var imageContainer =   $('<div> '+files[file].size+' </div>'),
                                            image = $('<img>'); 
                                      
                                            if(files[file].size === "original"){
                                                imageContainer.addClass('col-md-12 mt-5').css('border','1px solid rgb(0,0,0,0.1)'); 
                                                image.css({
                                                    width: '100%',
                                                    height:'100%',
                                                })
                                            }else{
                                                imageContainer.addClass('col-md-2 mt-5').css('border','1px solid rgb(0,0,0,0.1)'); 
                                            }                                                                                
                                            image.attr({
                                                alt :  files[file].name,
                                                src :  files[file].path,
                                            });
                                            image.appendTo(imageContainer);
                                            imageContainer.appendTo(showContainer);   
                                    }
                                })
                            
                           
                            showContainer.addClass('col-md-12 mt-5 mb-5').css('border','1px solid rgb(0,0,0,0.1)'); 
                            listImage.parents('form').parent().css('display','none');
                            listImage.parents('form').parent().parent().append(showContainer);
                    }else{
                        
                         return Swal.fire({
                            type: 'warning',
                            title: 'Oop!',
                            html: response.message,
                            showConfirmButton: true,
                            onClose :function(e){
                                listImage.parents('form').find('[type="submit"]').removeAttr('disabled');
                                listImage.parent().find('.proccessing').remove();
                            }
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });

          });
        }
       
    };
    pages.init();
    }
   
})(jQuery);
