<!-- Footer -->
<footer id="footer" class="bg-gradient1-{{config("app.theme_color.name")}} footer mt-2"
    data-theme-bg-color="gradient-{{config("app.theme_color.name")}}">

    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-xs-6">
                <span class="text-white title">{{Translator::phrase("quick_links")}}</span>
                <ul class="list-unstyled quick-links">
                    <li>
                        <a href="{{route("home")}}">
                            <i class="fas fa-home"></i>{{Translator::phrase("home")}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route("about")}}">
                            <i class="fas fa-info-circle"></i>{{Translator::phrase("about")}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route("contact")}}">
                            <i class="fas fa-address-book"></i>{{Translator::phrase("contact")}}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-xl-4 col-xs-6">
                <span class="text-white title">{{Translator::phrase("social_media")}}</span>
                <ul class="list-unstyled quick-links">
                    @foreach (config("app.socail") as $media)
                    <li>
                        @if ($media["link"] !=NULL )
                        <a href="{{$media["link"]}}">
                            <i class="{{$media["icon"]}}"></i>
                            {{Translator::phrase($media["name"])}}
                        </a>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
            
            <div class="col-xl-4 col-xs-6">
                <span class="text-white title">{{Translator::phrase("ស្វែងរកតាមបណ្តាញសង្គមFacebook")}}</span>
                <ul class="list-unstyled quick-links">
                    <li>
                        <div class="fb-page" data-href="https://www.facebook.com/rpitssr.page/" data-width=""
                            data-height="" data-small-header="false" data-adapt-container-width="true"
                            data-hide-cover="false" data-show-facepile="true">
                        </div>
                    </li>

                </ul>
            </div>
        </div>
        
        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">
                <!--<span class="text-white h3">{{Translator::phrase("sponsored_by")}}</span>-->
                <span class="text-white h3">ប្រពន្ធគ្រប់​គ្រប់គ្រងសិស្ស-EIMS Management System</span>
            </div>
        </div>
        
    </div>
</footer>
