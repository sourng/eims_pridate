"use strict";
String.prototype.replaceAll = function(a, b) {
    return this.replace(new RegExp(a.replace(/([.?*+^$[\]\\(){}|-])/ig, "\\$1"), 'ig'), b)
}

var channel = pusher.subscribe("feed-channel");

var app = {
    Gallery: function() {
        this.init = function() {
            this.builder();
        }
        ;
        this.builder = function(containerGallery) {
            var self = this;
            var e = containerGallery ? containerGallery : $(".card-gallery");
            e.length && e.each(function(i) {
                var col1 = ""
                  , col2 = "";
                var gallery = $(e[i]);
                var allMedia = $(gallery).find("embed");

                $.each(allMedia, function(i, media) {
                    var id = $(media).data("id");
                    var type = $(media).data("type");
                    var source = $(media).data("src") ? $(media).data("src") : $(media).data("original");
                    var sourceOriginal = $(media).data("original") ? $(media).data("original") : source;
                    var template = self.template(source, sourceOriginal, id, type);

                    if (allMedia.length == 5) {
                        if (i == 0 || i == 1) {
                            col1 += template;
                        } else {
                            if (i == 2 || i == 3 || i == 4) {
                                col2 += template;
                            }
                        }

                        gallery.removeClass("five").addClass("five");
                    } else if (allMedia.length == 4) {
                        if (i == 0 || i == 1) {
                            col1 += template;
                        } else {
                            if (i == 2 || i == 3) {
                                col2 += template;
                            }
                        }

                        gallery.removeClass("four").addClass("four");
                    } else if (allMedia.length == 3) {
                        if (i == 0) {
                            col1 += template;
                        } else {
                            if (i == 1 || i == 2) {
                                col2 += template;
                            }
                        }

                        gallery.removeClass("three").addClass("three");
                    } else if (allMedia.length == 2) {
                        if (i == 0) {
                            col1 += template;
                        } else {
                            if (i == 1) {
                                col2 += template;
                            }
                        }

                        gallery.removeClass("two").addClass("two");
                    } else if (allMedia.length == 1) {
                        gallery.removeClass("one").addClass("one");
                        col1 += template;
                    } else {
                        gallery.removeClass("five").addClass("five");
                        if (i == 0 || i == 1) {
                            col1 += template;
                        } else {
                            if (i == 2 || i == 3) {
                                col2 += template;
                            } else {
                                if (i == 4) {
                                    col2 += self.template(source, sourceOriginal, id, type, false, parseInt(allMedia.length) - 5);
                                } else {
                                    col2 += self.template(source, sourceOriginal, id, type, true);
                                }
                            }
                        }
                    }
                });
                gallery.html(self.columns(col1, col2));
                if (col2 == "") {
                    gallery.find("video.h-100").removeClass("h-100").addClass("post");
                }

                new LazyLoad({
                    callback_loaded: el=>{
                        $(el).parent().find(".swiper-lazy-preloader").remove();
                    }
                },gallery.find("img"));
            });
        }
        ;
        this.template = function(source, sourceOriginal, id, type, hidden, more) {
            var hidden = hidden ? "d-none" : "";
            var more = more ? '<div class="remaining">+' + more + "</div>" : "";
            var template = "";
            if (type == "image") {
                template = '<div class="image card-modal-open ' + hidden + '"  data-toggle="modal" data-target=".card-modal" data-id="' + id + '" data-type="' + type + '" data-original="' + sourceOriginal + '"  data-src="' + source + '">';
                template += more;
                template += '<div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>';
                template += '<img data-src="' + source + '">';
                template += "</div>";
            } else if ("video") {
                template = '<div class="video card-modal-open ' + hidden + '" data-target=".card-modal" data-id="' + id + '" data-type="' + type + '" data-original="' + sourceOriginal + '"  data-src="' + source + '">';
                template += more;
                template += '<div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>';
                template += '<video class="h-100" data-poster="" data-src="' + source + '" id="player">';
                template += '<source data-src="' + source + '" type="video/mp4" />';
                template += '<source data-src="' + source + '" type="video/webm" />';
                //template += '<track kind="captions" label="English captions" src=".vtt" srclang="en" default />';
                template += "</video>";
                template += "</div>";
            }

            return template;
        }
        ;
        this.columns = function(col1, col2) {
            var create = "";
            if (col1 && col2) {
                create = '<div class="container"><div class="row"><div class="col-xl-6 col-md-6 col-sm-6 col-xs-6 im-col-1">' + '<div class="row">' + col1 + "</div>" + "</div>" + '<div class="col-xl-6 col-md-6 col-sm-6 col-xs-6 im-col-2">' + '<div class="row">' + col2 + "</div>" + "</div>" + "</div>" + "</div>";
            } else {
                create = '<div class="container"><div class="row"><div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 im-col-12">' + '<div class="row">' + col1 + "</div>" + "</div>";
            }

            return create;
        }
        ;
    },
    Videos: function() {
        (this.init = function() {
            this.builder();
        }
        ),
        (this.builder = function(videoElement, currentTime=0, autoplay=false) {
            var playerI18n = $.getJSON(location.origin + "/assets/vendor/plyr/dist/i18n/" + $("html").attr("lang") + ".json");
            var e = videoElement ? videoElement : $("video#player");
            e.length && e.each(function() {
                new LazyLoad({
                    callback_loaded: el=>{
                        const player = new Plyr(el,{
                            controls: ["play-large", "play", "progress", "current-time", "mute", "volume", "captions", "settings", "airplay", "fullscreen"],
                            resetOnEnd: false,
                            autoplay: autoplay,
                            muted: true,
                            i18n: playerI18n.responseJSON
                        });
                        player.on("ready", event=>{
                            const instance = event.detail.plyr;
                            $(instance.elements.container).parent().find(".swiper-lazy-preloader").remove();
                        }
                        );
                        player.currentTime = currentTime;
                        player.on("play", event=>{
                            const instance = event.detail.plyr.media;
                            $.each($('video[data-was-processed="true"]'), function() {
                                if (this.plyr && this.plyr.playing) {
                                    if (instance !== this.plyr.media) {
                                        this.plyr.pause();
                                    }
                                }
                            });
                        }
                        );
                        player.on("enterfullscreen", event=>{
                            const instance = event.detail.plyr;
                            if ($(instance.elements.container).parent().hasClass("card-modal-open")) {
                                player.fullscreen.exit();
                                var model = new app.Modal();
                                model.builder($(instance.elements.container).parent());
                                $(".card-modal").modal("show");
                            }
                        }
                        );
                    }
                },$(this));
            });
        }
        );
    },
    Modal: function() {
        this.init = function() {
            this.onclose();
            this.onopen();
            this.onback();
        }
        ;
        (this.builder = function(element) {
            var card = $(element).parents(".card").clone();
            var index = 0;
            var textCaption = card.find(".text-caption").html();
            var media = card.find(".card-gallery .card-modal-open");

            card.find(".emojionearea").remove();
            card.find(".card-gallery").remove();
            card.find(".text-caption").html("");
            $(".card-modal .card-modal-content").html(card.html());

            $(".card-modal .card-modal-content").attr("data-feed-id", card.data("feed-id"));

            var comment = new app.Comment();
            comment.builder($(".card-modal .card-modal-content").find('input[data-toggle="comment"]'), "top");
            var replied = new app.RepliedComment();
            replied.builder($(".card-modal .card-modal-content").find('input[data-toggle="replied-comment"]'));

            var reaction = new app.Reaction();
            reaction.builder($(".card-modal .card-modal-content").find('[data-toggle="reaction"]'));

            $(".card-modal .card-modal-content").find('[data-sticker-convert="true"]').removeClass("sticker-loaded").html("").StickersLoad();


            $(".card-modal .card-modal-content>.card-body").scrollLock();

            $(".card-modal .card-modal-content").find(".text-caption").html(textCaption);

            var videos = new app.Videos();
            $(".card-modal .swiper-wrapper").html("");
            $.each(media, function(i) {
                var type = $(this).data("type");
                var source = $(this).data("original");
                var id = $(this).data("id");
                var currentTime = null;
                var autoplay = null;
                var template = "";
                if ($(element).data("id") == id) {
                    index = i;
                    if ($(element).data("type") == "video") {
                        currentTime = $(element).find("video").get(0).plyr.currentTime;
                        autoplay = true;
                    }
                }

                if (type == "image") {
                    template = '<div class="swiper-slide">';
                    template += '<div class="swiper-zoom-container">';
                    template += '<div class="swiper-lazy-preloader"></div>';
                    template += '<img data-src="' + source + '" class="swiper-lazy" />';
                    template += "</div>";
                    template += "</div>";
                } else if (type == "video") {
                    template = '<div class="swiper-slide">';
                    template += '<div class="swiper-zoom-container">';
                    template += '<div class="swiper-lazy-preloader"></div>';
                    template += '<video class="" data-poster="" data-src="' + source + '" id="player">';
                    template += '<source data-src="' + source + '" type="video/mp4" />';
                    template += '<source data-src="' + source + '" type="video/webm" />';
                    //template += '<track kind="captions" label="English captions" src=".vtt" srclang="en" default />';
                    template += "</video>";
                    template += "</div>";
                    template += "</div>";
                }
                $(".card-modal .swiper-wrapper").append(template);
                videos.builder($(".card-modal #player"), currentTime, autoplay);
            });

            history.pushState(null, null, "#modal");
            var swiper = new Swiper(".swiper-container",{
                zoom: true,
                pagination: ".swiper-pagination",
                nextButton: ".swiper-button-next",
                prevButton: ".swiper-button-prev",
                initialSlide: index,
                keyboardControl: true,
                lazyLoading: true,
                lazyLoadingInPrevNext: true,
                lazyLoadingInPrevNextAmount: true,
                lazyLoadingOnTransitionStart: true,
                preloadImages: false
            });
            swiper.on("onSlideChangeStart", function(t) {
                $.each(t.wrapper.find('video[data-was-processed="true"]'), function() {
                    if (this.plyr && this.plyr.playing) {
                        this.plyr.pause();
                    }
                });

                if ($(t.slides[t.activeIndex]).find("video").length) {// $(t.slides[t.activeIndex]).find("video").get(0).plyr.play();
                }
            });

            $(".card-modal .swiper-wrapper .swiper-zoom-container img").each(function(){
                var self = $(this);
                var image = new Image();
                    image.onload = function(){

                        if(this.height > window.innerHeight){
                            self.css({
                                height : 'calc('+window.innerHeight+'px - 2pc)'
                            });
                        }
                    }
                    image.src = self.data("src");
            });

        }
        ),
        (this.onclose = function() {
            $(".card-modal").on("hidden.bs.modal", function() {
                $(".card-modal .swiper-container").each(function() {
                    this.swiper.removeAllSlides();
                    this.swiper.destroy(true, true);
                });
            });
        }
        );
        this.onopen = function() {
            var self = this;
            $(document).on("click dblclick", ".card-modal-open", function(event) {
                var element = this;
                if ($(event.target).is(".remaining")) {
                    $(".card-modal").modal("show");
                }
                if (self.builder(this)) {
                    spacer($(".card-modal .card-excerpt"), 75);
                    if (/Mobi/.test(navigator["userAgent"])) {
                        var height = window.innerHeight ? window.innerHeight : $(window).height();
                        $(".card-modal-gallery .swiper-slide").css("height", height + "px");
                    }
                }
            });
        }
        ;
        this.onback = function() {
            $(window).on("popstate", function() {
                $(".card-modal").modal("hide");
            });
        }
        ;
    },
    Global: function() {
        this.init = function() {
            this.card_affix();
            this.load_more_items();
        }
        ;
        this.card_affix = function(element) {
            var _0x2dcax1a = $(".card-affix");
            if ($(window).width() >= 992) {
                for (var i = 0; i < _0x2dcax1a.length; i++) {
                    if ($(_0x2dcax1a[i]).css({
                        width: $(_0x2dcax1a[i]).parent(".card-wrapper").width(),
                        top: "0px"
                    })) {
                        $(_0x2dcax1a[i]).affix({
                            offset: {
                                top: 20
                            }
                        });
                    }
                }
            }
        }
        ;
        this.load_more_items = function(element) {
            if (!$(".card-posts").attr("data-page")) {
                $(".card-posts").attr("data-page", 1);
            }
            var a = null;
            $(window).scroll(function() {
                if ($(".card-posts-wrapper").length) {
                    if ($(document).height() <= $(window).scrollTop() + $(window).height() && $(".preload").length == 0) {
                        var last_page = $(".card-posts[data-feed-id]").last();
                        var page = parseInt(last_page.attr("data-page")) + 1;

                        if (page) {
                            $(".card-posts-wrapper").append(preload());
                            if (a) {
                                a.abort();
                            }
                            a = $.ajax({
                                type: "POST",
                                url: location.origin + "/ajax",
                                data: {
                                    page: page
                                },
                                success: function(feed) {
                                    if (feed) {
                                        $(".preload").remove();
                                        var ajaxFeed = new app.AjaxFeed();
                                        var template = $(ajaxFeed.template(feed, $('[data-toggle="feed-post"]').attr("action")));
                                        $(".card-posts-wrapper").append(template);
                                        ajaxFeed.builder(template);

                                    } else {
                                        $(".preload").html("");
                                    }
                                }
                            });
                        }
                    }
                }
            });
        }
        ;
    },
    LinkPreview: function() {
        (this.init = function() {
            var e = $('[data-toggle="link"]');
            var a = null;
            e.length && e.each(function() {
                $(this).on("input", function(event) {
                    event.preventDefault();
                    var link = $(this).val();
                    var target = $(this).data("target");

                    if (link) {
                        if (a) {
                            a.abort();
                        }
                        var linkPreview = new app.LinkPreview();
                        a = linkPreview.builder($(this).data("url"), link, target);
                    } else {
                        $(target).addClass("d-none");
                    }
                    $(target).find('[name="link_view"]').unbind().on("change", function() {
                        var view = $(this).val();
                        var showTab = $(this).data("target");
                        $('[data-target="' + showTab + '"]').parent().find(".active").removeClass("active");
                        $('[data-target="' + showTab + '"]').tab("show");
                    });
                });
            });
        }
        ),
        (this.builder = function(action, link, target) {
            if (action && link && target) {
                var formData = new FormData();
                formData.append("link", link);
                var loading = $('<div class="loading" style="background-color: rgba(0, 0, 0, 0.4); position: absolute; height: 100%; width: 100%; z-index: 2;"><div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"><div class="spinner spinner-3 text-blue"></div></div></div>');

                return $.ajax({
                    url: action,
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $(target).find("div.loading").remove();
                        $(target).removeClass("d-none").find(".card").prepend(loading);
                        $(target).find(".card-header").removeClass("d-none").addClass("invisible");
                        $(target).find(".tab-content").addClass("invisible");
                        $(target).find("#small-image").addClass("show active");
                        $(target).find("#small-image").addClass("show active");
                    },
                    success: function(response) {
                        $('[data-target="#small-image"]').parent().find(".active").removeClass("active");
                        loading.remove();
                        if (response.success) {
                            $(target).find("div.loading").remove();
                            $(target).removeClass("invisible");
                            $(target).find(".card-header").removeClass("invisible");
                            $(target).find(".tab-content").removeClass("invisible");

                            var card = $(target).find(".card");
                            card.addClass("small-image");
                            card.find(".title").text(response.data.title);
                            card.find(".image").attr("src", response.data.image);
                            card.find(".description").text(response.data.description);
                            card.find("[href]").attr("href", response.data.url);
                            var iframe = $(response.data.code);
                            iframe.attr({
                                width: "100%"
                            });
                            if (response.data.type == "video") {
                                card.find("#show_video").parent().removeClass("d-none");
                                card.find("#show-video>.card-body").html(iframe);
                            } else {
                                card.find("#show_video").parent().addClass("d-none");
                                card.find("#show-video>.card-body").html("");
                            }
                            card.find(".card-header").removeClass("invisible");
                            $('[data-target="#small-image"]').tab("show");
                        } else {
                            $(target).addClass("d-none");
                            $(target).find(".card-header").addClass("invisible");
                            $('[data-target="#small-image"]').parent().find(".active").removeClass("active");
                        }
                    }
                });
            }
        }
        );
    },
    AjaxFeed: function() {
        (this.init = function() {
            channel.bind("post-event", ({feed})=>{
                var template = $(this.template(feed, $('[data-toggle="feed-post"]').attr("action")));
                $(".card-posts-wrapper").prepend(template);
                this.builder(template);
            });
        }
        ),
        (this.template = function(feed, action) {
            if (feed.success) {
                var template = "";
                $.each(feed.data, function() {
                    if ($('.card-posts[data-feed-id="' + this.id + '"]').length == 0) {
                        template += '<div class="card mb-2 card-posts" data-page="' + (feed.hasOwnProperty("pages") ? feed.pages.current_page : 1) + '" data-feed-id="' + this.id + '">';
                        template += '<div class="card-header d-flex align-items-center p-2 m-0">';
                        template += '<div class="d-flex align-items-center card-author-avatar">';
                        template += '<a href="#"><img data-src="' + this.user.profile + '" class="avatar rounded-circle"></a>';
                        template += '<div class="mx-3">';
                        template += '<div class="card-author">';
                        template += '<a data-toggle="card-author" data-user=\''+JSON.stringify(this.user)+'\' href="#" class="text-dark font-weight-600 text-sm">' + this.user.name + "</a>";
                        template += "</div>";
                        template += "<div>";
                        template += '<small class="text-muted mr-2 card-who-see" data-toggle="who-see" data-a="' + this.who_see + '"><i class="fas fa-' + (this.who_see == "public" ? "globe-asia" : "lock") + '"></i> </small>';
                        template += '<small class="text-muted card-time text-xs" datetime="' + this.created_at + '"></small>';
                        template += "</div>";
                        template += "</div>";
                        template += "</div>";
                        template += "</div>";

                        template += '<div class="card-body p-0">';

                        var ajaxFeed = new app.AjaxFeed();

                        if(this.type == "share"){
                            template +=  ajaxFeed.templateShare(this.share.node);
                        }else{
                            template +=  ajaxFeed.templatePost(this);
                        }


                        var reaction = new app.Reaction();
                        template += reaction.template(this.id, action , this.reaction);

                        template += '<div class="mb-1 card-comments-wrapper"></div>';
                        template += "</div>";

                        if (window.User) {
                            var comment = new app.Comment();
                            template += comment.form(this.id, action);
                        }

                        template += "</div>";
                    }
                });

                return template;
            }
        }
        ),
        this.templatePost = function(post){
            var template = "";
            var caption = post.post_message;
            if(post.mention){
                $.each(post.mention,function(key){
                    var t = '<a href="#" data-user=\''+JSON.stringify(this)+'\' class="emojionearea-mention">'+this.name+'</a>';
                    caption  = caption.replaceAll("@["+key+"]",t);

                });

            }
            if (post.type == "text") {
                if (post.theme_color) {
                    template += '<div class="post text-white bg-gradient-' + post.theme_color.color_name + '">';
                    template += '<div class="post-body">';
                    template += '<span class="mb-1 text-xl text-center font-weight-600" data-emoji-convert="true">' + caption + "</span>";
                    template += "</div>";
                    template += "</div>";
                } else {
                    template += '<p class="mb-1 p-2 text-sm font-weight-400 text-pre-wrap" data-emoji-convert="true"> ' + caption + " </p>";
                }
            } else if (post.type == "media") {
                if (caption) {
                    template += '<p class="mb-1 p-2 text-sm font-weight-400 text-pre-wrap" data-emoji-convert="true"> ' + caption + " </p>";
                }

                if (post.media) {
                    template += '<div class="card-gallery" data-toggle="gallery-feed1">';
                    $.each(post.media, function(i, im) {
                        template += '<embed data-id="' + im.id + '" data-type="' + im.type + '" data-src="' + im.source + (im.type == "image" ? "?type=large" : "") + '"  data-original="' + im.source + (im.type == "image" ? "?type=original" : "") + '" />';
                    });

                    template += "</div>";
                }
            } else if (post.type == "link") {
                if (caption) {
                    template += '<p class="mb-1 p-2 text-sm font-weight-400 text-pre-wrap" data-emoji-convert="true"> ' + caption + " </p>";
                }
                $.each(post.link, function(i, im) {
                    if (im.view == 1) {
                        template += '<div class="row align-items-center">';
                        template += '<div class="col-auto">';
                        template += '<a href="' + im.link + '" target="_blank">';
                        template += '<img data-src="' + im.image + '" alt="" class="image" width="200px" height="200px">';
                        template += "</a>";
                        template += "</div>";
                        template += '<div class="col ml--2">';
                        template += '<h4 class="mb-0">';
                        template += '<a href="' + im.link + '" target="_blank" class="title">' + im.title + "</a>";
                        template += "</h4>";
                        template += '<p class="text-sm text-muted mb-0 description">' + im.description + "</p>";
                        template += "</div>";
                        template += "</div>";
                    } else if (im.view == 2) {
                        template += '<a href="' + im.link + '" target="_blank">';
                        template += '<img data-src="' + im.image + '" alt="" class="image w-100" >';
                        template += "</a>";
                        template += '<div class="align-items-center">';
                        template += '<div class="col mt-2">';
                        template += '<h4 class="mb-0">';
                        template += '<a href="' + im.link + '" target="_blank" class="title">' + im.title + "</a>";
                        template += "</h4>";
                        template += '<p class="text-sm text-muted mb-0 description">' + im.description + "</p>";
                        template += "</div>";
                        template += "</div>";
                    } else if (im.view == 3) {
                        template += im.code;
                    }
                });
            }
            return template;
        },
        this.templateShare = function(post){
            var template = '<div class="card-shared border m-3" data-share-feed-id="'+post.id+'">';
                template += '<div class="card-header d-flex align-items-center p-2 m-0">';
                template += '<div class="d-flex align-items-center card-author-avatar">';
                template += '<a href="#"><img data-src="' + post.user.profile + '" class="avatar rounded-circle"></a>';
                template += '<div class="mx-3">';
                template += '<div class="card-author">';
                template += '<a data-toggle="card-author" data-user=\''+JSON.stringify(post.user)+'\' href="#" class="text-dark font-weight-600 text-sm">' + post.user.name + "</a>";
                template += "</div>";
                template += "<div>";
                template += '<small class="text-muted mr-2 card-who-see" data-toggle="who-see" data-a="' + post.who_see + '"><i class="fas fa-' + (post.who_see == "public" ? "globe-asia" : "lock") + '"></i> </small>';
                template += '<small class="text-muted card-time text-xs" datetime="' + post.created_at + '"></small>';
                template += "</div>";
                template += "</div>";
                template += "</div>";
                template += "</div>";

                var ajaxFeed = new app.AjaxFeed();
                template += '<div class="card-body p-0">';
                template +=  ajaxFeed.templatePost(post);
                template += "</div>";
            return template;
        },
        (this.builder = function($template) {
            if ($template.find(".card-gallery").length) {
                var gallery = new app.Gallery();
                gallery.builder($template.find(".card-gallery"));
            }

            if ($template.find("video#player").length) {
                var video = new app.Videos();
                video.builder($template.find("video#player"));
            }

            if ($template.find('[data-toggle="comment"]').length) {
                var comment = new app.Comment();
                comment.builder($template.find('[data-toggle="comment"]'));
            }

            if ($template.find('[data-toggle="reaction"]').length) {
                var reaction = new app.Reaction();
                reaction.builder($template.find('[data-toggle="reaction"]'));

            }

            $template.find("[datetime]").timeago();
            $template.find('[data-emoji-convert="true"]').emojioneAreaText();

            var hovercard = new app.Hovercard();
                hovercard.builder($template.find('[data-toggle="card-author"]'));

                if($template.find(".card-shared").length)
                {
                    var node_id = $template.find(".card-shared").data("share-feed-id");
                    $template.find('[data-toggle="share"]').attr("data-feed-id",node_id);
                    var share = new app.Share();
                        share.builder($template.find('[data-toggle="share"]'));

                }

            if (lazyLoadInstance) {
                lazyLoadInstance.update();
            }
        }
        );
    },
    Share : function(){
        this.init = function(){
            this.builder();
            this.onclose();
            this.form();
        },
        this.builder = function(element){

            var e = element ? element : $('[data-toggle="share"]');
            e.length && e.each(function(){
                $(this).click(function(event){
                    event.preventDefault();
                    var feed_id = $(this).data("feed-id");
                    var card = $(this).parents(".card-posts").clone();
                        card.removeClass().addClass("card-share border m-3")
                        card.find(".card-options").parent().remove();
                        card.find(".card-footer").remove();
                        card.find('[data-toggle="modal"]').removeAttr("data-toggle");
                        card.find(".card-comments-wrapper").remove();
                    var modal =  $(".modal-share");
                    var input = $('<input type="hidden" name="node_id">').val(feed_id);
                        modal.find("form").prepend(input);
                        modal.find("textarea.post-message").get(0).emojioneArea.editor.addClass("border").css({height:"auto",minHeight:50});

                        modal.find(".emojionearea-button").show();
                        if(card.find(".card-shared").length){
                            modal.find(".modal-body").html(card.find(".card-shared").clone());
                        }else{
                            modal.find(".modal-body").html(card);
                        }
                        modal.find(".modal-body").scrollbar().scrollLock();
                        modal.modal("show");
                        modal.find("textarea.post-message").get(0).emojioneArea.editor.focus();
                });
            });

        },
        this.form = function(form){
            var e = form ? form : $("form#form-share");
                e.length &&
                e.each(function(){
                    $(this).submit(function(event){
                        event.preventDefault();
                        $.ajax({
                            url : $(this).attr("action"),
                            method : "POST",
                            data: new FormData(event.target),
                            processData: false,
                            contentType: false,
                            beforeSend: function() {},
                            success: function(response) {
                                if (response.success) {
                                    event.target.reset();
                                    $(event.target).find(".emojionearea-editor").html("");
                                    var ajaxFeed = new app.AjaxFeed();
                                    var template = $(ajaxFeed.template(response, $(event.target).attr("action")));
                                    $(".card-posts-wrapper").prepend(template);
                                    ajaxFeed.builder(template);
                                }
                            }
                        });
                    });
                });

        },
        this.onclose = function() {
            $(".modal-share").on("hidden.bs.modal", function() {
               $(this).find(".modal-body").scrollbar("destroy");
               $(this).find('[name="node_id"]').remove();
            });
        }
    },
    Comment: function() {
        (this.init = function() {
            var e = $('[data-sticker-convert="true"]');
            e.length &&
                e.css({width : 64 ,height:74}).StickersLoad();

            this.builder();
            channel.bind("comment-event", ({feed})=>{
                if (feed.success) {
                    $.each(feed.data, function() {
                        var cardPost = $('.card-posts[data-feed-id="' + this.feed_id + '"]');
                        var cardComment = cardPost.find(".card-comments-wrapper");
                        if (cardPost.length && cardComment.length) {
                            if (cardComment.find('[data-comment-id="' + this.id + '"]').length == 0) {
                                var count_old_comment = cardPost.find('[data-toggle="view-comment"]').attr("data-count");
                                count_old_comment = parseInt(count_old_comment);
                                cardPost.find('[data-toggle="view-comment"]').attr("data-count", count_old_comment + 1);

                                var comment = new app.Comment();
                                var template = $(comment.template(this, $('[data-toggle="feed-comment"]').attr("action")));

                                cardComment.append(template);
                                template.find('[data-emoji-convert="true"]').emojioneAreaText();
                                template.find('[data-sticker-convert="true"]').StickersLoad();
                                var hovercard = new app.Hovercard();
                                    hovercard.builder(template.find(".emojionearea-mention"));

                                var replied = new app.RepliedComment();
                                replied.builder(cardComment.find('[data-comment-id="' + this.id + '"]').find('[data-toggle="replied-comment"]'));
                                $("[datetime]").timeago();

                                if (lazyLoadInstance) {
                                    lazyLoadInstance.update();
                                }
                            }
                        }
                    });
                }
            }
            );
        }
        ),
        (this.builder = function(inputElement, emojionePosition) {
            var e = inputElement ? inputElement : $('.card-posts [data-toggle="comment"]');
            if (e.length) {
                var emojione = new app.Emojione();
                emojione.builder(e, emojionePosition);
                e.parents("form").on("submit", function(event) {
                    event.preventDefault();
                    var a = $.ajax({
                        url: $(this).attr("action"),
                        method: "POST",
                        data: new FormData(event.target),
                        processData: false,
                        contentType: false,
                        beforeSend: function() {},
                        success: function(response) {
                            if (response.success) {
                                $(event.target).find('[name="comment"]').get(0).emojioneArea.setText("");
                                $.each(response.data, function() {
                                    var cardPost = $('.card-posts[data-feed-id="' + this.feed_id + '"]');
                                    var cardComment = cardPost.find(".card-comments-wrapper");

                                    if (cardPost.length && cardComment.length) {
                                        if (cardComment.find('[data-comment-id="' + this.id + '"]').length == 0) {
                                            var count_old_comment = cardPost.find('[data-toggle="view-comment"]').attr("data-count");
                                            count_old_comment = parseInt(count_old_comment);
                                            cardPost.find('[data-toggle="view-comment"]').attr("data-count", count_old_comment + 1);

                                            var comment = new app.Comment();
                                            var template = $(comment.template(this, $(event.target).attr("action")));
                                            cardComment.append(template);
                                            template.find('[data-emoji-convert="true"]').emojioneAreaText();
                                            template.find('[data-sticker-convert="true"]').StickersLoad();
                                            var hovercard = new app.Hovercard();
                                            hovercard.builder(template.find(".emojionearea-mention"));
                                            var replied = new app.RepliedComment();
                                            replied.builder(cardComment.find('[data-comment-id="' + this.id + '"]').find('[data-toggle="replied-comment"]'));
                                            $("[datetime]").timeago();

                                            if (lazyLoadInstance) {
                                                lazyLoadInstance.update();
                                            }
                                        }
                                    }
                                });
                            }
                        }
                    });
                });
            }
        }
        ),
        (this.template = function(comment, action) {
            if (comment) {
                var replied = new app.RepliedComment();
                var template = '<div class="ct-comment media media-comment py-2" data-comment-id="' + comment.id + '">';
                    template += '<img alt="" class="avatar avatar-sm media-comment-avatar rounded-circle" data-src="' + comment.user.profile + '">';
                    template += '<div class="media-body">';
                    template += '<div class="media-comment-text">';
                    template += '<div class="d-flex">';
                    template += '<div class="'+((comment.type == "text") ? "d-flex bg-secondary": "")+' rounded-lg p-1">';
                    template += '<h6 class="h5 text-nowrap mb-0">' + comment.user.name + "</h6>";
                var c = comment.comment;

                if(comment.mention){
                    $.each(comment.mention,function(key){
                        var t = '<a href="#" data-user=\''+JSON.stringify(this)+'\' class="emojionearea-mention">'+this.name+'</a>';
                        c  = c.replaceAll("@["+key+"]",t);
                    });
                }

                if(comment.type == "text"){
                    template += '<span class="text-sm ml-2" data-emoji-convert="true">' + c + "</span>";
                }else{
                    template += '<span class="text-sm ml-2" data-sticker-convert="true" data-name="'+ c +'"></span>';
                }

                template += "</div>";
                template += "</div>";
                template += '<div class="icon-actions d-inline-flex">';
                template += '<small class="text-muted text-xs text-right ml-auto" datetime="' + comment.created_at + '"></small>';


                template += "</div>";
                template += '<div class="ct-replied ct-replied card-replieds-wrapper">';
                $.each(comment.replied, function(i, replied) {
                    template += replied.template(replied);
                });
                template += "</div>";
                if (window.User) {
                    template += replied.form(comment.id, action);
                }
                template += "</div>";
                template += "</div>";

                return template;
            }
        }
        ),
        (this.form = function(feed_id, action) {
            if ($(".comment-template").length) {
                $(".comment-template").find('[name="feed_id"]').val(feed_id);
                var template = $(".comment-template").html();
                return template;
            }
        }
        );
    },
    RepliedComment: function() {
        (this.init = function() {
            var e = $('[data-sticker-convert="true"]');
            e.length &&
                e.css({width : 64 ,height:74}).StickersLoad();
            this.builder();
            channel.bind("replied-event", ({feed})=>{
                if (feed.success) {
                    $.each(feed.data, function() {
                        var cardComment = $('.media-comment[data-comment-id="' + this.comment_id + '"]');
                        var cardReplied = cardComment.find(".card-replieds-wrapper");
                        if (cardComment.length && cardReplied.length) {
                            if (cardReplied.find('[data-replied-id="' + this.id + '"]').length == 0) {
                                var cardPost = cardComment.parents(".card-posts");
                                var count_old_comment = cardPost.find('[data-toggle="view-comment"]').attr("data-count");
                                count_old_comment = parseInt(count_old_comment);
                                cardPost.find('[data-toggle="view-comment"]').attr("data-count", count_old_comment + 1);

                                var replied = new app.RepliedComment();
                                var template = $(replied.template(this));
                                cardReplied.append(template);
                                template.find('[data-emoji-convert="true"]').emojioneAreaText();
                                template.find('[data-sticker-convert="true"]').StickersLoad();
                                var hovercard = new app.Hovercard();
                                    hovercard.builder(template.find(".emojionearea-mention"));
                                $("[datetime]").timeago();
                                if (lazyLoadInstance) {
                                    lazyLoadInstance.update();
                                }
                            }
                        }
                    });
                }
            }
            );
        }
        ),
        (this.builder = function(inputElement) {
            var e = inputElement ? inputElement : $('.card-posts [data-toggle="replied-comment"]');
            if (e.length) {
                var emojione = new app.Emojione();
                emojione.builder(e);
                e.parents("form").on("submit", function(event) {
                    event.preventDefault();
                    var a = $.ajax({
                        url: $(this).attr("action"),
                        method: "POST",
                        data: new FormData(event.target),
                        processData: false,
                        contentType: false,
                        beforeSend: function() {},
                        success: function(response) {
                            if (response.success) {
                                $(event.target).find('[name="comment"]').get(0).emojioneArea.setText("");
                                $.each(response.data, function() {
                                    var cardComment = $('.media-comment[data-comment-id="' + this.comment_id + '"]');
                                    var cardReplied = cardComment.find(".card-replieds-wrapper");
                                    if (cardComment.length && cardReplied.length) {
                                        if (cardReplied.find('[data-replied-id="' + this.id + '"]').length == 0) {
                                            var replied = new app.RepliedComment();
                                            var template = $(replied.template(this));
                                            cardReplied.append(template);
                                            template.find('[data-emoji-convert="true"]').emojioneAreaText();
                                            template.find('[data-sticker-convert="true"]').StickersLoad();
                                            var hovercard = new app.Hovercard();
                                                hovercard.builder(template.find(".emojionearea-mention"));
                                            $("[datetime]").timeago();
                                            if (lazyLoadInstance) {
                                                lazyLoadInstance.update();
                                            }
                                        }
                                    }
                                });
                            }
                        }
                    });
                });
            }
        }
        ),
        (this.template = function(replied) {
            if (replied) {
                var template = '<div class="media media-comment pl-2" data-comment-id="' + replied.comment_id + '">';
                template += '<div class="media" data-replied-id="' + replied.id + '">';
                template += '<img alt="" class="avatar avatar-xs rounded-circle mr-2" data-src="' + replied.user.profile + '">';
                template += '<div class="media-body">';
                template += '<div class="media-comment-text p-0">';
                template += '<div class="'+((replied.type == "text") ? "d-flex bg-secondary": "")+' rounded-lg p-1">';
                template += '<h6 class="h5 text-nowrap mb-0">' + replied.user.name + "</h6>";
                var c = replied.comment;
                if(replied.mention){
                    $.each(replied.mention,function(key){
                        var t = '<a href="#" data-user=\''+JSON.stringify(this)+'\' class="emojionearea-mention">'+this.name+'</a>';
                        c  = c.replaceAll("@["+key+"]",t);
                    });
                }
                if(replied.type == "text"){
                    template += '<span class="text-sm ml-2" data-emoji-convert="true">' + c + "</span>";
                }else{
                    template += '<span class="text-sm ml-2" data-sticker-convert="true" data-name="'+ c +'"></span>';
                }

                template += "</div>";
                template += '<div class="icon-actions d-inline-flex">';
                template += '<small class="text-muted text-xs text-right ml-auto" datetime="' + replied.created_at + '"></small>';
                template += "</div>";
                template += "</div>";
                template += "</div>";
                template += "</div>";
                return template;
            }
        }
        ),
        (this.form = function(comment_id, action) {
            if ($(".replied-template").length) {
                $(".replied-template").find('[name="comment_id"]').val(comment_id);
                var template = $(".replied-template").html();
                return template;
            }
        }
        );
    },
    Emojione: function() {
        (this.init = function() {
            var e = $('[data-emoji-convert="true"]');
            e.length && setTimeout(function() {
                e.emojioneAreaText();
                var hovercard = new app.Hovercard();
                    hovercard.builder(e.find(".emojionearea-mention"));
            }, 1000);
        }
        ),
        (this.builder = function(element, position) {
            var options = {
                pickerPosition: position ? position : "bottom",
                filtersPosition: position ? position : "bottom",
                search: false,
                tonesStyle: "bullet",
                autocomplete:true,
                events: {
                    ready: function() {
                        if(this.source.is("INPUT")){
                            this.editor.Stickers({
                                onSticker : (element, btnSticker , sticker)=>{
                                    var input = $('<input type="hidden" name="type">').val("sticker");
                                    element.parents("form").find('[name="comment"]').val(sticker.name);
                                    element.parents("form").append(input);
                                    element.parents("form").submit();
                                    element.parents("form").find('[name="comment"]').val(null);
                                    input.val("text");
                                    element.parents("form").find(".sticker-button").tooltipster('hide');
                                }
                            });
                        }


                        var mention_url = this.source.data("mention-url");
                        this.editor.textcomplete([{
                            id: 'emojionearea',
                            match: /\B@([\-\d\w]*[^@\s]*)$/,
                            search:  (term, callback) =>{
                                    $.ajax({
                                        url :mention_url,
                                        method : "GET",
                                        dataType : "json",
                                        data : {search : term},
                                        success : (response)=>{
                                            if(response.success){
                                                callback($.map(response.data,(users)=>{
                                                    if(this.editor.find('[data-mention-id="'+users.id+'"]').length == 0){
                                                        return users;
                                                    }
                                                }));
                                            }else{
                                                callback(response.data);
                                            }
                                        }
                                    });


                            },
                            template:  (value)=> {
                                var t = '<div class="py-2"><img class="rounded-circle" width="30px" height="30px" src="'+value.profile+'"/><b class="ml-2">' + value.name + '</b> </div>';
                                return t;
                            },
                            replace:  (value)=> {
                                var t =  '<div data-mention="@['+value.id+']" class="d-inline-flex text-blue bg-secondary w-auto" contenteditable="false"><span>' + value.name + '</span> </div>&nbsp;';

                                return t;
                            },
                            cache: true,
                            index: 1
                        }]);
                    },

                    click: function(editor, event) {
                        //this.source.val(this.source.get(0).emojioneArea.getText());
                    },
                    keyup: function(editor, event) {
                        if (this.source.is("INPUT") && event.keyCode == 13) {
                            var text = editor.clone();
                            text.find("[data-mention]").each(function(el){
                                var mention = $(this).data("mention");
                                    $(this).after(mention);
                                    $(this).remove();
                            });
                            text.find(".emojioneemoji").each(function(el){
                                var emoji = $(this).attr("alt");
                                    $(this).after(emoji);
                                    $(this).remove();
                            });
                            if($('[data-strategy="emojionearea"]').length == 0){
                                this.source.val(text.text());
                                editor.parents("form").submit();
                            }

                        }
                        var count = this.source.get(0).emojioneArea.getText().length;
                        this.source.parents("form").find("#limit-words-count").html(count+"/150");

                        //this.source.val(this.source.get(0).emojioneArea.getText());

                        var bgColor = this.source.parents("form").find(".post-message.emojionearea").attr("data-bg-color");
                        if(count > 150){
                            this.source.get(0).emojioneArea.editor.addClass("limit-words");
                            this.source.parents("form").find('[id^="ckk-theme-color"]').prop("checked",false).prop("disabled",true).trigger("change");
                        }else{
                            this.source.get(0).emojioneArea.editor.removeClass("limit-words");
                            this.source.parents("form").find('[id^="ckk-theme-color"]').prop("disabled",false);
                            if(bgColor){
                                this.source.parents("form").find('[id^="ckk-theme-color"]').prop("checked",true).trigger("change");
                            }
                        }

                    },
                    emojibtn_click: function(button, event) {
                        var count = this.source.get(0).emojioneArea.getText().length;
                        this.source.parents("form").find("#limit-words-count").html(count+"/150");

                        //this.source.val(this.source.get(0).emojioneArea.getText());
                        var bgColor = this.source.parents("form").find(".post-message.emojionearea").attr("data-bg-color");
                        if(count > 150){
                            this.source.get(0).emojioneArea.editor.addClass("limit-words");
                            this.source.parents("form").find('[id^="ckk-theme-color"]').prop("checked",false).prop("disabled",true).trigger("change");
                        }else{
                            this.source.get(0).emojioneArea.editor.removeClass("limit-words");
                            this.source.parents("form").find('[id^="ckk-theme-color"]').prop("disabled",false);
                            if(bgColor){
                                this.source.parents("form").find('[id^="ckk-theme-color"]').prop("checked",true).trigger("change");
                            }
                        }
                    },
                    paste: function(editor, text, html) {
                        var items = (event.clipboardData || event.originalEvent.clipboardData).items;
                        var fileHelper = new app.FileHelper();
                        for (var i in items) {
                            var item = items[i];
                            if (item.kind === "file") {
                                var file = item.getAsFile();
                                fileHelper.upload(file, editor.parents("form").find('[name="media"]'), "image");
                                editor.parents("form").find('[data-target="#post-media"]').trigger("click");
                            }
                        }
                    },
                    picker_show: function(editor) {
                        if ($(window).height() - editor.get(0).getBoundingClientRect().y < editor.height()) {
                            editor.removeClass("emojionearea-picker-position-bottom").addClass("emojionearea-picker-position-top");
                        } else {
                            editor.removeClass("emojionearea-picker-position-top").addClass("emojionearea-picker-position-bottom");
                        }
                    },
                    picker_hide: function(editor) {
                        if ($(window).height() - editor.get(0).getBoundingClientRect().y < editor.height()) {
                            editor.removeClass("emojionearea-picker-position-bottom").addClass("emojionearea-picker-position-top");
                        } else {
                            editor.removeClass("emojionearea-picker-position-top").addClass("emojionearea-picker-position-bottom");
                        }
                    }
                }
            };

            element.length && element.emojioneArea(options);
            element.each(function(){
                this.emojioneArea.on("@blur",function(){
                    return false;
                })
            });



        }
        );
    },
    Reaction: function() {
        (this.init = function() {
            this.builder();
            channel.bind("reaction-event", ({feed})=>{
                if (feed.success) {
                    this.react(feed.data);
                }
            }
            );
        }
        ),
        (this.builder = function(element) {
            var self = this;
            var e = element ? element : $('[data-toggle="reaction"][data-feed-id]');
                e.find("form").remove();
            e.length && e.each(function() {
                var a = null;
                var form = $(this).find("form");
                $(this).tooltipster({
                    interactive: true,
                    content: 'Loading...',
                    contentCloning: false,
                    contentAsHTML: true,
                    position: 'top-left',
                    positionTracker : true,
                    animation: 'fade',
                    animationDuration : 0,
                    timer : 15000,
                    functionBefore: (origin, continueTooltip)=> {
                        continueTooltip();
                        var feed_id  = $(this).data("feed-id");
                        var template = $(self.template(feed_id));
                            form = $(template).find("form");
                            form.find(".reactions-box").css("display","inline-flex");
                            form.find(".reactions-box>.reaction").on("click", function() {
                                var data_reaction = $(this).data("reaction").toLowerCase();
                                form.find('[name="type"]').val(data_reaction);
                                form.submit();
                            });

                            form.on("submit", function(event) {
                                event.preventDefault();
                                if (a) {
                                    a.abort();
                                }
                                a = $.ajax({
                                    url: form.attr("action"),
                                    method: "POST",
                                    data: new FormData(event.target),
                                    processData: false,
                                    contentType: false,
                                    beforeSend: function() {},
                                    success: function(response) {
                                        if (response.success) {
                                            self.react(response.data);
                                        }
                                    }
                                });
                            });
                        origin.tooltipster('content', form);
                    }
                });
                $(this).click(function(event){
                    event.preventDefault();
                    var feed_id = $(this).data("feed-id");
                    var react = $(this).attr("data-react");
                    var t = $(self.template(feed_id));
                        t.find("form").submit(function(event){
                            event.preventDefault();
                            if (a) {
                                a.abort();
                            }
                            a = $.ajax({
                                url: $(this).attr("action"),
                                method: "POST",
                                data: new FormData(event.target),
                                processData: false,
                                contentType: false,
                                beforeSend: function() {},
                                success: function(response) {
                                    if (response.success) {
                                        self.react(response.data);
                                    }
                                }
                            });
                        });

                        if(react){
                            t.find('[name="type"]').val(null);
                        }else{
                            t.find('[name="type"]').val('like');
                        }

                        t.find("form").trigger("submit");

                });
            });
        }
        ),
        (this.template = function(feed_id, action,reaction) {
            if ($(".reaction-template").length) {
                var template = $(".reaction-template").clone();
                    template.find('[data-toggle="reaction"]').attr("data-feed-id",feed_id);
                    template.find('[name="feed_id"]').val(feed_id);
                    template.find("[data-feed-id]").attr("data-feed-id", feed_id);
                    this.react(reaction,template);
                    template.find("[data-feed-id]").attr("data-feed-id", feed_id);
                return template.html();
            }
        }
        ),
        (this.react = function(react , card) {
            if (react) {
                $.each(react, function() {
                    var feed_id = this.feed_id;
                    var cardPost = card ? card : $('.card-posts[data-feed-id="' + feed_id + '"]');
                    var card_reaction_wrapper = cardPost.find(".card-reaction-wrapper");
                        cardPost.find('[data-toggle="view-reaction"]').attr("data-count", this.like);
                    var you_react = this.you_react;
                    var lable_you = $(".reaction-details").data("lable-you");
                    var lable_other = "";
                    var reaction_stat = null;
                        cardPost.find('[data-toggle="reaction"]').attr("data-react",you_react);
                    if (card_reaction_wrapper.find(".reaction-stat").length) {
                        reaction_stat = card_reaction_wrapper.find(".reaction-stat");
                    } else if (card_reaction_wrapper.find(".reaction-stat-clone")) {
                        reaction_stat = card_reaction_wrapper.find(".reaction-stat-clone").removeClass().addClass("col reaction-stat");
                    }
                    reaction_stat.find(".reaction-emo").html("");

                    $.each(this.reaction, (i,type)=> {

                        if (type) {
                            reaction_stat.find(".reaction-emo").append('<span class="reaction-btn-' + type + '"></span>');
                        }
                    });
                    lable_other = this.other_react_name;
                    if (you_react) {
                        cardPost.find(".reaction-btn-emo").removeClass().addClass("reaction-btn-emo").addClass("reaction-btn-" + you_react);
                        var lableReact = $(".reaction-" + you_react).data("lable");
                            cardPost.find(".reaction-btn-text").text(lableReact).removeClass().addClass("reaction-btn-text").addClass("reaction-btn-text-" + you_react).addClass("active");
                            card_reaction_wrapper.find(".reaction-stat").find(".reaction-details").attr("data-you-react", you_react);

                        if (lable_other) {
                            reaction_stat.find(".reaction-details").html(lable_you + ", " + lable_other);
                        } else {
                            reaction_stat.find(".reaction-details").html(lable_you);
                        }
                    } else {
                        var llike = $(".reaction-like").data("lable");
                        cardPost.find(".reaction-btn-emo").removeClass().addClass("reaction-btn-emo fas fa-thumbs-up");

                        cardPost.find(".reaction-btn-text").text(llike).removeClass().addClass("reaction-btn-text");

                        if (lable_other) {
                            reaction_stat.find(".reaction-details").html(lable_other);
                        } else {
                            reaction_stat.removeClass().addClass("col reaction-stat-clone");
                            reaction_stat.find(".reaction-details").html("");
                        }
                    }
                });
            }
        }
        );
    },
    FileHelper: function() {
        (this.media = function(files, self) {
            // self = <input>
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                if (file.type.match("image.*")) {
                    this.upload(file, self, "image");
                } else if (file.type.match("video.*")) {
                    this.upload(file, self, "video");
                }
            }
            self.val("");
            var newInput = self.parent().parent().parent().clone();
            self.parent().parent().parent().after(newInput);
            self.parent().parent().parent().hide();
        }
        ),
        (this.upload = function(file, self, type) {
            var a = null;
            var li = $("<li>");
            var loading = $('<div class="loading"><div class="c100 p0 small" style=" top: 50%; left: 50%; transform: translate(-50%, -50%); margin: auto; "> <span>0%</span> <div class="slice"> <div class="bar"></div> <div class="fill"></div> </div> </div></div><div  class="post-thumb"><div class="inner-post-thumb"><a href="javascript:void(0);" class="remove"><i class="fas fa-times" aria-hidden="true"></i></a><div></div>');
            li.html(loading);
            var formData = new FormData();
            formData.append("media[]", file);
            formData.append("type", type);

            a = $.ajax({
                url: self.data("url"),
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                xhr: function () {
                    var xhr =  new XMLHttpRequest();
                    xhr.onprogress = function (e) {
                        if (e.lengthComputable) {
                           // console.log(parseInt(e.loaded / e.total * 100) + '%');
                        }
                    };
                    xhr.upload.onprogress = function (e) {
                        if (e.lengthComputable) {
                            loading.find(".c100")
                            .removeClass().addClass("c100 small p"+parseInt(e.loaded / e.total * 100))
                            .find("span").text(parseInt(e.loaded / e.total * 100) + "%");

                        }
                    };
                    return xhr;
                },
                beforeSend: function() {
                    self.parent().parent().parent().before(li);
                    self.parent().parent().parent().parent().animate({
                        scrollLeft: "+=100"
                    }, "fast");
                },
                success: function(response) {
                    if (response.success) {
                        $.each(response.data, function() {
                            if (this.type == "image") {
                                li.find(".remove").before('<a href="javascript:void(0);" class="float-left ml-1 text-lighter"><i class="fas fa-image" aria-hidden="true"></i></a>');
                                li.find(".loading").after('<div class="load-img"></div><input type="hidden" value="" name="media_files[]"/><img data-src="' + this.source + '">');
                            } else if (this.type == "video") {
                                li.find(".remove").before('<a href="javascript:void(0);" class="float-left ml-1 text-lighter"><i class="fas fa-video" aria-hidden="true"></i></a>');
                                li.find(".loading").after('<div class="load-img"></div><input type="hidden" value="" name="media_files[]"/><video data-src="' + this.source + '"></video');
                            }
                            li.find('[name="media_files[]"]').val(JSON.stringify(this));
                            li.find(".loading").remove();
                        });
                    }
                    new LazyLoad({
                        callback_loaded: el=>{
                            li.find(".load-img").remove();
                        }
                    },li.find("img"));

                    new LazyLoad({
                        callback_loaded: el=>{
                            li.find(".load-img").remove();
                        }
                    },li.find("video"));
                }
            });

            li.find(".remove").on("click", function(event) {
                event.preventDefault();
                li.remove();
                a.abort();
            });
        }
        );
    },
    ScrollTo: function() {
        (this.init = function() {
            this.builder();
        }
        ),
        (this.builder = function(element) {
            var e = element ? element : $('[data-toggle="scroll-to"]');

            e.on("click", function(event) {
                var user =  $(this).data("user");
                var target = $(this).data("target");
                var focus_name = $(this).data("focus");

                if ($(target).length) {
                    event.preventDefault();

                    // $("html, body").animate({
                    //     scrollTop: $(target).offset().top - 77
                    // }, 800, function() {
                    //     window.location.hash = target;
                    // });
                    //$(target).find('[name="' + focus_name + '"]').get(0).emojioneArea.setFocus();
                    var t = '<div data-mention="@['+user.id+']" class="d-inline-flex text-blue bg-secondary w-auto" contenteditable="false"><span>' + user.name + '</span> </div>&nbsp;';
                    if($(target).find('[name="' + focus_name + '"]').data("emojioneArea").getText()){

                    }else{
                        $(target).removeClass("d-none").find('[name="' + focus_name + '"]').get(0).emojioneArea.editor.html(t);
                    }
                    function placeCaretAtEnd(el) {
                        if (typeof window.getSelection != "undefined"
                                && typeof document.createRange != "undefined") {
                          var range = document.createRange();
                          range.selectNodeContents(el);
                          range.collapse(false);
                          var sel = window.getSelection();
                          sel.removeAllRanges();
                          sel.addRange(range);
                        } else if (typeof document.body.createTextRange != "undefined") {
                          var textRange = document.body.createTextRange();
                          textRange.moveToElementText(el);
                          textRange.collapse(false);
                          textRange.select();
                        }
                      }
                      $(target).find('[name="' + focus_name + '"]').data("emojioneArea").editor.focus();
                    placeCaretAtEnd($(target).find('[name="' + focus_name + '"]').data("emojioneArea").editor[0]);

                }
            });
        }
        );
    },
    Notification: function() {
        (this.init = function() {
            channel.bind("notification-event", ({feed})=>{
                if (feed.success) {
                    this.builder(feed);
                }
            }
            );
        }
        ),
        (this.builder = function(notification) {
            if (notification.success) {
                $.each(notification.data, function(i, im) {
                    var media = "";
                    if (im.media) {
                        $.each(im.media, function(i, m) {
                            if (m.type == "image") {
                                media += '<img data-src="' + m.source + '">';
                            }
                        });
                    }

                    if (window.User) {
                        if (im.user.id != window.User.id) {
                            $.notify({}, {
                                type: "default",
                                placement: {
                                    from: "bottom",
                                    align: "left"
                                },
                                timer: 1500,
                                template: ' <div data-notify="container" data-id="" class="border-0 list-group-item list-group-item-action alert" role="alert">\
                                                <button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>\
                                                <a href="' + im.url + '" target="_blank" data-notify="url">\
                                                <div class="row align-items-left px-3">\
                                                    <div class="avatar rounded-circle">\
                                                        <img  data-src="' + im.user.profile + '" alt="">\
                                                    </div>\
                                                    <div class="col ml--2">\
                                                        <div class="d-flex">\
                                                            <div>\
                                                                <h4 class="mb-0 text-sm text-white">\
                                                                ' + im.user.name + '\n\
                                                                </h4>\
                                                            </div>\
                                                            <span class="reaction-emo ml-2"><span class="reaction-btn-' + im.react + '"></span></span>\
                                                        </div>\
                                                        <div class="text-sm mb-0 text-white gallery" data-toggle="gallery-feed">\
                                                        ' + media + '\n\
                                                        </div>\
                                                    </div>\
                                                </div>\
                                        <div class="progress" data-notify="progressbar">\
                                        <div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>\
                                    </div>\
                                    </a>\
                                 </div>'
                            });
                        }
                    }
                });

                $('[data-notify="container"]:last').find('[data-toggle="gallery-feed"]').each(function() {
                    var images = $.map($(this).children(), function(el) {
                        return $(el).data("src");
                    });
                    $(this).addClass("loaded").imagesGrid({
                        images: images,
                        align: true,
                        getViewAllText: function(imgsCount) {
                            return "+" + (imgsCount - 5);
                        }
                    });
                });

                if (lazyLoadInstance) {
                    lazyLoadInstance.update();
                }
            }
        }
        );
    },
    FeedPost : function() {
        this.init = function(){
            this.builder();
        },
        this.builder = function(element){
            var e = element ? element : $('form[data-toggle="feed-post"]');
            e.length && e.each(function() {
                var form = $(this);
                $(this).on("submit", function(event) {
                    event.preventDefault();
                    var editor = $(this).find('[name="post_message"]').data("emojioneArea").editor;
                      var text = editor.clone();
                            text.find("[data-mention]").each(function(el){
                                var mention = $(this).data("mention");
                                    $(this).after(mention);
                                    $(this).remove();
                            });
                            text.find(".emojioneemoji").each(function(el){
                                var emoji = $(this).attr("alt");
                                    $(this).after(emoji);
                                    $(this).remove();
                            });




                    var loading = $('<div class="loading"><div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div></div>');
                    var formData = new FormData(event.target);
                        formData.append("post_message",text.text());
                    if ($(this).find('[name="type"]').val() == "text") {
                        formData.delete("media");
                        formData.delete("media_files");
                        formData.delete("link");
                        formData.delete("link_view");
                    } else if ($(this).find('[name="type"]').val() == "media") {
                        formData.delete("media");
                        formData.delete("link");
                        formData.delete("link_view");
                        formData.delete("theme_color");
                    } else if ($(this).find('[name="type"]').val() == "link") {
                        formData.delete("media");
                        formData.delete("media_files");
                        formData.delete("theme_color");
                    }
                    $.ajax({
                        url: $(this).attr("action"),
                        method: "POST",
                        data: formData,
                        type: "POST",
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $(event.target).find(".create-post-overlay").css({
                                display: "none"
                            });
                            if (!$(event.target).find(".create-post").hasClass("posting")) {
                                $(event.target).find(".create-post").addClass("posting");
                            }
                            if ($(event.target).find(".create-post>.loading").length == 0) {
                                $(event.target).find(".create-post").prepend(loading);
                            }
                        },
                        success: function(response) {
                            loading.remove();
                            if (response.success) {
                                event.target.reset();
                                $(event.target).find(".emojionearea-editor").html("");
                                $(event.target).find("ul#media-list>li:not(.myupload)").remove();
                                $(event.target).find('[id^="ckk-theme-color"]').prop("checked", false).trigger("change");
                                $(event.target).find('[data-toggle="link"]').val("").trigger("input");

                                var ajaxFeed = new app.AjaxFeed();
                                var template = $(ajaxFeed.template(response, $(event.target).attr("action")));
                                $(".card-posts-wrapper").prepend(template);
                                ajaxFeed.builder(template);
                            }
                        }
                    });
                });


                form.find(".create-post").on({
                    dragover: function(event) {
                        var drop = "Drop Link/Files Here";
                        var data = event.originalEvent.dataTransfer.items;
                        if (data[0].kind === "file") {
                            drop = "Drop Files Here";
                        } else {
                            drop = "Drop Link Here";
                        }
                        $(this).find("div.in-bag span").html(drop);
                    },
                    dragleave: function() {
                        $(this).find("div.in-bag span").html("Drag Link/Files Here");
                    },
                    drop: function(event) {
                        var files = event.originalEvent.dataTransfer.files;
                        var data = event.originalEvent.dataTransfer.items;
                        if (data[0].kind == "file") {
                            var input_image = $(this).find('[name="media"]');
                            var fileHelper = new app.FileHelper();
                            fileHelper.media(files, input_image);
                            $(this).find('[data-target="#post-media"]').trigger("click");
                        } else if (event.originalEvent.dataTransfer.getData("URL")) {
                            $(this).find('[name="link"]').val(event.originalEvent.dataTransfer.getData("URL")).trigger("input");
                            $(this).find('[data-target="#post-link"]').trigger("click");
                        }
                        event.stopPropagation();
                        event.preventDefault();
                        $(this).find("div.in-bag.drag-drop").remove();
                    },
                    click: function() {
                        form.find(".create-post-overlay").fadeIn(500);
                        form.find('[data-target="post-btn"]').addClass("d-flex");

                        var bgColor = form.find(".post-message.emojionearea").attr("data-bg-color");
                        if (form.find('[name="type"]').val() == "text") {
                            form.find(".post-message>.emojionearea-editor").attr("data-type", "text");
                            if (bgColor && form.find('[id^="ckk-theme-color"]').is(":checked")) {
                                form.find(".post-message.emojionearea").addClass("post");
                                form.find(".post-message.emojionearea").addClass(bgColor);
                            }
                            form.find("#post-theme-color").addClass("show");
                            form.find(".post-message.emojionearea").addClass("focused");
                        } else {
                            if (form.find('[name="type"]').val() == "media") {
                                form.find("#post-media").addClass("show");
                            } else if (form.find('[name="type"]').val() == "link") {
                                form.find("#post-link").addClass("show");
                            }
                            form.find(".post-message.emojionearea").removeClass("post");
                            form.find(".post-message.emojionearea").removeClass(bgColor);
                        }
                        form.find(".post-message .emojionearea-button").fadeIn(500);
                    }
                });
                var feedPostMeida = new app.FeedPostMeida();
                    feedPostMeida.builder(form.find('[data-toggle="feed-media"]'));

                var feedPostBackgroud = new app.FeedPostBackgroud();
                    feedPostBackgroud.builder(form.find('[data-toggle="post-background"]'));

            });
        }


    },
    FeedPostMeida : function() {
        this.init = function(){
            this.builder();
        },
        this.builder = function(element){
            var e = element ? element : $('[data-toggle="feed-media"]');
            e.length && e.each(function() {
            $(this).on("click", function(event) {
                if (!$(this).hasClass("active")) {
                    var form = $(this).parents("form");
                    var target = $(this).data("target");
                    var type = $(this).data("type");
                    form.find(".post-message>.emojionearea-editor").attr("data-type", type);
                    form.find('[name="type"]').val(type);
                    $(this).parent().find(".active").removeClass("active");
                    $(this).addClass("active");
                    if (form.find(target).length) {
                        $(this).parent().find("[data-type]").each(function() {
                            var all_target = $(this).data("target");
                            form.find(all_target).collapse("hide");
                        });
                        if (type == "media") {
                            if (form.find(target).find("input").length == 1) {
                                form.find(target).find('input[name="media"]').click();
                            }
                        }
                        form.find(target).collapse("show");
                    }
                }
                event.preventDefault();
            });
        });
        }
    },
    FeedPostBackgroud : function() {
        this.init = function(){
            this.builder();
        },
        this.builder = function(element){
            var e = element ? element : $('[data-toggle="post-background"]');
            e.length && e.each(function() {
                $(this).on("click", function(event) {
                    event.preventDefault();
                    var form = $(this).parents("form");
                    var bgColorId = $(this).data("id");
                    var bgColor = $(this).data("color");
                    var target = $(this).data("target");
                        $(this).parent().find("label")
                        .removeClass("active")
                        .removeClass("focus");

                        $(this).addClass("focus active").find('[name="theme_color"]').prop("checked",true).trigger("change");
                    if (form.find(target).length) {
                        if (form.find(target).hasClass("post") == false) {
                            form.find(target).addClass("post");
                        }
                        if (form.find(target).hasClass("text-white") == false) {
                            form.find(target).addClass("text-white");
                        }

                        if (form.find(target).attr("data-bg-color")) {
                            if (form.find(target).hasClass(form.find(target).attr("data-bg-color"))) {
                                form.find(target).removeClass(form.find(target).attr("data-bg-color"));
                                form.find(target).attr("data-bg-color", bgColor);
                            }
                            form.find(target).addClass(bgColor);
                        } else {
                            form.find(target).attr("data-bg-color", bgColor);
                            form.find(target).addClass(bgColor);
                        }

                        if (form.find(target).find(".emojionearea-editor").hasClass("post-body") == false) {
                            form.find(target).find(".emojionearea-editor").addClass("post-body");
                        }
                    }
                    form.find(".post-message").data("emojioneArea").editor.focus();
                    return false;
                });
            });
            var a = e.parents("form").find('[id="ckk-theme-color"]');
            a.length &&
            a.each(function(i){
                var new_id = $(this).attr("id")+i;
                $(this).attr("id",new_id);
                $(this).parent().find("label").attr("for",new_id);

                $(this).on("change", function(event) {
                    var form = $(this).parents("form");
                    var target = $(this).data("target");
                    var bgColor = form.find(".post-message.emojionearea").attr("data-bg-color");
                    if ($(this).is(":checked")) {
                        if (bgColor) {
                            form.find(".post-message.emojionearea").addClass("post");
                            form.find(".post-message.emojionearea").addClass(bgColor);
                            form.find('[data-color="' + bgColor + '"]>input').prop("checked", true);
                            form.find(".post-message.emojionearea").addClass("focused");
                        }

                        form.find(target).collapse("show");
                    } else {
                        form.find(".post-message.emojionearea").removeClass("post");
                        form.find(".post-message.emojionearea").removeClass(bgColor);
                        form.find("input").prop("checked", false);
                        form.find(target).collapse("hide");
                    }
                    form.find(".emojionearea-editor").focus();
                });
            });
        }
    },
    Hovercard : function(){
        this.init = function(){
            this.builder();
        },
        this.builder = function(element){
            var self = this;
            var e = element ? element : $('[data-toggle="card-author"]')
                e.length &&
                e.each(function(){
                    $(this).tooltipster({
                        interactive: true,
                        content: 'Loading...',
                        contentCloning: false,
                        contentAsHTML: true,
                        position: 'top-left',
                        positionTracker : true,
                        animation: 'fade',
                        animationDuration : 0,
                        timer : 15000,

                        functionBefore: (origin, continueTooltip)=> {
                            // we'll make this function asynchronous and allow the tooltip to go ahead and show the loading notification while fetching our data.
                            continueTooltip();
                            var template = $(self.template($(this).data("user")));

                                new LazyLoad({
                                    callback_loaded: el=>{
                                        //$(el).parent().find(".swiper-lazy-preloader").remove();
                                    },callback_error :el=>{
                                        $(el).removeAttr("src");
                                    }
                                },template.find("img"));
                            origin.tooltipster('content', template);


                        }
                    });
                })
        },
        this.template = function(user){

            var template = '<div class="hovercard">';
                template += '<div>';
                template += '<div class="display-pic">';
                template += '<div class="cover-photo">';
                template += '<div class="display-pic-gradient"></div>';
                template += '<img data-src="http://rpitssr.edu/images/feature/27720116_111483131821611_4518591155221611671_n.jpg?type=cover"/>';
                template += '</div>';
                template += '<div class="profile">';
                template += '<div class="avatar-pic">';
                template += '<img data-src="'+user.profile+'"/>';
                template += '</div>';
                template += '<div class="title-container">';
                template += '<div class="author">';
                template += '<a class="title title font-weight-600 text-sm" href="#">'+user.name+'</a>';
                template += '<p class="other-info">2 followers</p>';
                template += '</div>';
                template += '<div class="details">';
                template += '<ul class="details-list">';
                template += '<li class="details-list-item">';
                template += '<span class="fas fa-home"></span>';
                template += '<span> Also Lives in ';
                template += '<a href="#">Chennai</a>';
                template += '<a href="#">TamilNadu</a>';
                template += '</span>';
                template += '</li>';
                template += '<li class="details-list-item">';
                template += '<span class="fas fa-briefcase"></span>';
                template += '<span> Founder at <a href="#">CodeDodle</a></span>';
                template += '</li>';
                template += '</ul>';
                template += '</div>';
                template += '</div>';
                template += '</div>';
                template += '</div>';
                template += '<div class="display-pic-gradient"></div>';
                template += '</div>';
                template += '</div>';

            return template;
        }
    }
};

function spacer(_0x15f0x2, _0x15f0x3) {
    console.log(_0x15f0x2, _0x15f0x3);
    var _0x15f0x4 = "";
    var _0x15f0x5 = _0x15f0x2;
    var _0x15f0x6 = words_counter(_0x15f0x2);
    if ($(window)["width"]() >= 768 && (!_0x15f0x6 || _0x15f0x6 <= 15)) {
        for (var i = 0; i < _0x15f0x3; i++) {
            _0x15f0x4 += "&nbsp; ";
        }
        _0x15f0x5["append"](_0x15f0x4);
    }
}

function words_counter(_0x15f0x2) {
    var _0x15f0x8 = _0x15f0x2["text"]()["match"](/[^\s]+/g);
    var _0x15f0x6 = _0x15f0x8 ? _0x15f0x8["length"] : 0;
    return _0x15f0x6;
}

function preload() {
    return '<div class="card preload clearfix"><div class="card-header d-flex p-2"><div class="card-author-avatar"><div class="card-author-avatar rounded-circle preload-bg"></div></div><div class="container"><div class="col-3 mb-2 preload-bg"></div><div class="col-5 preload-bg"></div></div></div><div class="card-body p-2"><div class="card-excerpt"><p class="col-xs-11 preload-bg"></p><p class="col-xs-10 preload-bg"></p><p class="col-xs-11 preload-bg"></p><p class="col-xs-7 preload-bg"></p></div></div></div>';
}

function getEvents(element) {
    var elemEvents = $._data(element, "events");
    var allDocEvnts = $._data(document, "events");
    for (var evntType in allDocEvnts) {
        if (allDocEvnts.hasOwnProperty(evntType)) {
            var evts = allDocEvnts[evntType];
            for (var i = 0; i < evts.length; i++) {
                if ($(element).is(evts[i].selector)) {
                    if (elemEvents == null) {
                        elemEvents = {};
                    }
                    if (!elemEvents.hasOwnProperty(evntType)) {
                        elemEvents[evntType] = [];
                    }
                    elemEvents[evntType].push(evts[i]);
                }
            }
        }
    }
    return elemEvents;
}

$(document).ready(function() {
    var gallery = new app.Gallery();
    gallery.init();
    var modal = new app.Modal();
    modal.init();

    var video = new app.Videos();
    video.init();

    var global = new app.Global();
    global.init();
    var ajaxFeed = new app.AjaxFeed();
    ajaxFeed.init();
    var linkPreview = new app.LinkPreview();
    linkPreview.init();
    var comment = new app.Comment();
    comment.init();
    var replied = new app.RepliedComment();
    replied.init();
    var emojione = new app.Emojione();
    emojione.init();
    emojione.builder($(".post-message"));
    var reaction = new app.Reaction();
    reaction.init();

    var share = new app.Share();
        share.init();

    var scrollTo = new app.ScrollTo();
    scrollTo.init();

    var notification = new app.Notification();
    notification.init();

     var feedPost = new app.FeedPost();
        feedPost.builder();
        var hovercard = new app.Hovercard();
        hovercard.init();


    $("body").on("change", ".media-upload", function(event) {
        var self = $(this);
        var fileHelper = new app.FileHelper();
        fileHelper.media(event.target.files, self);
        $(this).val("");
    });

    $(document).on({
        dragover: function() {
            if ($(".create-post").find("div.in-bag.drag-drop").length == 0) {
                $(".create-post").prepend('<div class="in-bag drag-drop"><span>Drag Link/Files Here</span></div>');
            }
            return false;
        },
        drop: function() {
            $(".create-post").find("div.in-bag.drag-drop").remove();
            return false;
        }
    });

    $("[datetime]").timeago();
    var GalleryFeed = (function() {
        var e = $('[data-toggle="gallery-feed"]');
            e.length && e.each(function() {
                var images = $.map($(this).children(), function(el) {
                    return $(el).data("src");
                });
                $(this).addClass("loaded").imagesGrid({
                    images: images,
                    align: true,
                    getViewAllText: function(imgsCount) {
                        return "+" + (imgsCount - 5);
                    }
                });
            });
        }
    )();

    $(".create-post-overlay").not(".create-post").click(function() {
        var form = $(this).parents("form");
        form.find('[data-target="post-btn"]').removeClass("d-flex");
        var bgColor = form.find(".post-message.emojionearea").attr("data-bg-color");
        form.find(".post-message.emojionearea").removeClass("post");
        form.find(".post-message.emojionearea").removeClass(bgColor);
        form.find(".post-message.emojionearea").removeClass("focused");

        form.find(".create-post-overlay").fadeOut(500);
        form.find(".post-message .emojionearea-button").fadeOut(500);
        form.find("#post-theme-color").removeClass("show");
        form.find("#post-media").removeClass("show");
        form.find("#post-link").removeClass("show");
    });
});
