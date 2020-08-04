@if ($sliders['success'])
<div class="col-12">
    <div id="carousel-indicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach ($sliders["data"] as $key => $item)
            <li data-target="#carousel-indicators" data-slide-to="{{$key}}" class="{{$item["status"]}}">
            </li>
            @endforeach

        </ol>
        <div class="carousel-inner">
            @foreach ($sliders["data"] as $key => $item)
            <div class="carousel-item {{$item["status"]}}">
                <img class="img-center w-100" style="max-height:400px;min-height:300px"
                    src="{{$item["image"]}}?type=slide" alt="{{$item["institute"]["name"]}}" />
            </div>
            @endforeach

        </div>
        <a class="carousel-control-prev" href="#carousel-indicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-indicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

</div>
@endif
 <div class="col-md-12">
    <section class="our-features section">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div style="padding:15px;text-align: center;">
							<h2>គោលដៅរបស់វិទ្យាស្ថាន</h2>
							<p>ផ្តល់ការអប់រំបណ្តុះបណ្តាលបច្ចេកទេស និងវិជ្ជាជីវៈ ដល់សិស្ស-និស្សិតទាំងប្រុសស្រី ដើម្បីជួយពួកគេឱ្យមានលទ្ធភាពបំរើប្រទេសជាតិប្រកបដោយ ភាពជឿ អប់រំសិស្ស-និស្សិតទាំងប្រុសស្រី លើជំនាញវិស្វកម្មសំណង់ស៊ីវិល វិស្វកម្មអគស្គិនី និងអេឡិចត្រូនិច ស្ថាបត្យកម្ម  ផ្តល់ឱកាសសម្រាប់ធ្វើការស្រាវជ្រាវ ដែលផ្តល់ផលប្រយោជន៍ដល់សង្គម និង បុគ្គល។និងបច្ចេកវិទ្យាព័ត៌មានវិទ្យា ។ជាក់ និងមោទនៈភាព។</p>
					
					       </p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 col-md-4 col-12">
						<!-- Single Feature -->
						<div class="single-feature">
							<div class="feature-head">
								<img style="width:100%;" src="https://eims.rpitssr.edu.kh/images/feature/27720116_111483131821611_4518591155221611671_n.jpg?type=slide" alt="#">
							</div>
							<h2 style="padding:15px;text-align: center;">វិទ្យាសាស្រ្តកុំព្យូទ័រ</h2>
							<p>យើងខ្ញុំបណ្តុះបណ្តាលដើម្បីឆ្លើយតបនឹងតម្រូវការទីផ្សារការងារ។</p>	
						</div>
						<!--/ End Single Feature -->
					</div>
					<div class="col-lg-4 col-md-4 col-12">
						<!-- Single Feature -->
						<div class="single-feature">
							<div class="feature-head">
								<img style="width:100%;" src="https://eims.rpitssr.edu.kh/images/feature/03501476_751111133978861_9102412169151741216_n.jpg?type=slide" alt="#">
							</div>
							<h2 style="padding:15px;text-align: center;">ជំនាញអគ្គិសនីគ្រប់​កម្រឹត</h2>
							<p>ជាជំនាញដែលសិស្សរៀនច្រើនជាងគេក្នុងតំបន់ និងមានទំនុកចិត្តខ្ពស់។</p>	
						</div>
						<!--/ End Single Feature -->
					</div>
					<div class="col-lg-4 col-md-4 col-12">
						<!-- Single Feature -->
						<div class="single-feature">
							<div class="feature-head">
								<img style="width:100%;" src="https://eims.rpitssr.edu.kh/images/feature/53013514_291119116501404_4112028292819116161_n.jpg?type=slide" alt="#">
							</div>
							<h2 style="padding:15px;text-align: center;">ជំនាញសំណង់</h2>
							<p>ជាជំនាញស្នូលសំខាន់សម្រាប់វិទ្យាស្ថាយើង។</p>	
						</div>
						<!--/ End Single Feature -->
					</div>
				</div>
			</div>
		</section>
</div>

<!--Sponsor-->

   @if ($sponsored["success"])
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">
                <span class="text-white h3">{{Translator::phrase("sponsored_by")}}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-5">
                <ul class="list-unstyled list-inline social text-center">
                    @foreach ($sponsored["data"] as $item)
                    <li class="img-thumbnail list-inline-item mb-2" width="150" height="150">
                        <a href="#">
                            <img class="img-responsive" width="150" height="150" src="{{$item["image"]}}" />
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
                

