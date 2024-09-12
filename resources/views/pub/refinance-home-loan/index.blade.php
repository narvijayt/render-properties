@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends("layouts.app")
@section('title', 'Sell Property')
@section('meta')
@if(!empty($meta))
@if(!is_null($meta->description))
{{ meta('description',html_entity_decode(strip_tags($meta->description))) }}
@else
{{ meta('description', config('seo.description')) }}
@endif
@if(!is_null($meta->keywords))
{{ meta('keywords', html_entity_decode(strip_tags($meta->keyword)))}}
@else
{{ meta('keywords', config('seo.keyword')) }}
@endif
@else
{{ meta('description', config('seo.description')) }}
{{ meta('keywords', config('seo.keyword')) }}
@endif
{{ openGraph('og:title', 'Home') }}
{{ openGraph('og:type', 'product') }}
{{ openGraph('og:url', Request::url()) }}
{{ openGraph('og:image', config('seo.image')) }}
{{ openGraph('og:description', config('seo.description')) }}
{{ openGraph('og:site_name', config('app.name')) }}
{{ openGraph('fb:admins', config('seo.facebook_id')) }}
{{ twitter('twitter:card', 'summary') }}
{{ twitter('twitter:site', config('seo.twitter_handle')) }}
{{ twitter('twitter:title', 'Home') }}
{{ twitter('twitter:description', config('seo.description')) }}
{{ twitter('twitter:creator', config('seo.twitter_handle')) }}
{{ twitter('twitter:image', config('seo.image')) }}
{{ googlePlus('name', 'Home') }}
{{ googlePlus('description', config('seo.description')) }}
{{ googlePlus('image', config('seo.image')) }}
@endsection

@section("content")
<!-- Banner -->
<div class="banner privacy">
    <div class="container">
        <h1 class="banner-title"> Refinance Your Home Loan</h1>
    </div>
</div>

<!-- Form -->
<div class="row">
    <div class="card property-form-outer property-Step-form">
        <!-- Progress Bar and Volume -->
        <div class="progress-outer">
            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" id="progress-bar" style="width: 0%;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <div class="container p-3 mb-3">
                <div class="multi-step-form">
                    <form id="multi-step-form">
                        
                        <!-- Step 1 -->
                        <div class="step" id="step-1">
                            <h2 class="text-center">What type of property you are refinancing?</h2>
                            <div class="step-inner">
                                <ul>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off">
                                            <label class="btn btn-secondary" for="option2">Single Family Home</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option3" autocomplete="off">
                                            <label class="btn btn-secondary" for="option3">Condominium</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option4" autocomplete="off">
                                            <label class="btn btn-secondary" for="option4">Townhome</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option05" autocomplete="off">
                                            <label class="btn btn-secondary" for="option05">Multi-Family Home</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="step-btn">
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="step" id="step-2">
                            <h2 class="text-center">Estimate your credit score.</h2>
                            <div class="step-inner">
                                <ul>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option5" autocomplete="off">
                                            <label class="btn btn-secondary" for="option5">Excellent 740+</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option6" autocomplete="off">
                                            <label class="btn btn-secondary" for="option6">Good 700-739</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option7" autocomplete="off">
                                            <label class="btn btn-secondary" for="option7">Average 660-699</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option8" autocomplete="off">
                                            <label class="btn btn-secondary" for="option8">Fair 600-659</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option9" autocomplete="off">
                                            <label class="btn btn-secondary" for="option9">Poor < 600</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="step" id="step-3">
                            <h2 class="text-center">How will this property be used?</h2>
                            <div class="step-inner">
                                <ul>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option10" autocomplete="off">
                                            <label class="btn btn-secondary" for="option10">Primary Home</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option11" autocomplete="off">
                                            <label class="btn btn-secondary" for="option11">Secondary Home</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option12" autocomplete="off">
                                            <label class="btn btn-secondary" for="option12">Rental Property</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 4-->
                        <div class="step" id="step-4">
                            <h2 class="text-center">Do you have second mortgage?</h2>
                            <div class="step-inner">
                                <ul>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option13" autocomplete="off">
                                            <label class="btn btn-secondary" for="option13">Yes</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option14" autocomplete="off">
                                            <label class="btn btn-secondary" for="option14">No</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 5-->
                        <div class="step" id="step-5">
                            <h2 class="text-center">Do you have second mortgage?</h2>
                            <div class="step-inner">
                                <div class="price-slider-container">
                                    <input type="range" id="priceRange-01" min="0" max="20000" value="50" step="1" oninput="updatePrice('priceRange-01', 'priceOutput-01', this.value)">
                                    <label for="priceRange-01">$<span id="priceOutput-01">0</span></label>
                                </div>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 6-->
                        <div class="step" id="step-6">
                            <h2 class="text-center">What is your employment status?</h2>
                            <div class="step-inner">
                                <ul>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option15" autocomplete="off">
                                            <label class="btn btn-secondary" for="option15">Employed</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option16" autocomplete="off">
                                            <label class="btn btn-secondary" for="option16">Not Employed</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option17" autocomplete="off">
                                            <label class="btn btn-secondary" for="option17">Not Employed</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option18" autocomplete="off">
                                            <label class="btn btn-secondary" for="option18">Military</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option19" autocomplete="off">
                                            <label class="btn btn-secondary" for="option19">Other</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 7-->
                        <div class="step" id="step-7">
                            <h2 class="text-center">Bankruptcy, short sale, or foreclosure <br> in the last 3 years?</h2>
                            <div class="step-inner">
                                <ul>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option20" autocomplete="off">
                                            <label class="btn btn-secondary" for="option20">Yes</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option21" autocomplete="off">
                                            <label class="btn btn-secondary" for="option21">No</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 8-->
                        <div class="step" id="step-8">
                            <h2 class="text-center">Can you show proof of income?</h2>
                            <div class="step-inner">
                                <ul>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option22" autocomplete="off">
                                            <label class="btn btn-secondary" for="option22">Yes</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option23" autocomplete="off">
                                            <label class="btn btn-secondary" for="option23">No</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 9-->
                        <div class="step" id="step-9">
                            <h2 class="text-center">What is your average monthly income?</h2>
                            <div class="step-inner">
                                <div class="price-slider-container">
                                    <input type="range" id="priceRange-02" min="0" max="20000" value="100" step="1" oninput="updatePrice('priceRange-02', 'priceOutput-02', this.value)">
                                    <label for="priceRange-02">$<span id="priceOutput-02">0</span></label>
                                </div>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 10-->
                        <div class="step" id="step-10">
                            <h2 class="text-center">What are your average monthly expenses?</h2>
                            <div class="step-inner">
                                <div class="price-slider-container">
                                    <input type="range" id="priceRange-02" min="0" max="20000" value="100" step="1" oninput="updatePrice('priceRange-03', 'priceOutput-03', this.value)">
                                    <label for="priceRange-03">$<span id="priceOutput-03">0</span></label>
                                </div>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 11-->
                        <div class="step" id="step-11">
                            <h2 class="text-center">Do you currently have an FHA loan?</h2>
                            <div class="step-inner">
                                <ul>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option24" autocomplete="off">
                                            <label class="btn btn-secondary" for="option24">Yes</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="radio-container">
                                            <input type="radio" class="btn-check" name="options" id="option25" autocomplete="off">
                                            <label class="btn btn-secondary" for="option25">No</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="step-btn">
                                <button type="button" class="btn btn-secondary prev" id="prevBtn" onclick="prevStep()">Previous</button>
                                <button type="button" class="btn btn-primary next" id="nextBtn" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 12-->
                        <div class="step" id="step-12">
                            <div class="step-inner">
                                <form>
                                    <div class="form-box">
                                        <div class="mb-0">
                                            <label for="firstName" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="firstName" placeholder="Enter your first name">
                                        </div>

                                        <div class="mb-0">
                                            <label for="lastName" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="lastName" placeholder="Enter your last name">
                                        </div>
                                    </div>

                                    <div class="form-box">
                                        <div class="mb-0">
                                            <label for="email" class="form-label">What is your email address?</label>
                                            <input type="email" class="form-control" id="email" placeholder="Enter your email">
                                        </div>
                                        <div class="mb-0">
                                            <label for="phone" class="form-label">What is your phone number?</label>
                                            <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number">
                                        </div>
                                    </div>

                                    <div class="form-text">
                                        <p>I agree to be contacted by Richard Tocado Companies, INC via call, email and text. To opt-out, you can reply “stop” at any time or click the unsubscribe link in the emails. Message and data rates may apply.</p>
                                    </div>

                                    <div class="quote-btn-outer">
                                        <button type="submit" class="btn btn-primary">Get My Quote </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts-footer')
 <script>
$(document).ready(function() {
    var currentStep = 1;

    // Show the first step
    $('#step-' + currentStep).addClass('step-active');

    // Next button click event
    $('.next').click(function() {
        $('#step-' + currentStep).removeClass('step-active');
        currentStep++;
        $('#step-' + currentStep).addClass('step-active');
    });

    // Previous button click event
    $('.prev').click(function() {
        $('#step-' + currentStep).removeClass('step-active');
        currentStep--;
        $('#step-' + currentStep).addClass('step-active');
    });
});
</script>


<script>
function updatePrice(sliderId, outputId, value) {
  document.getElementById(outputId).innerText = value;
 }

</script>

<script>
  let currentStep = 0; // Initial step
  const steps = document.getElementsByClassName("step");
  const progressBar = document.getElementById("progress-bar");

  // Show the first step
  showStep(currentStep);

  function showStep(step) {
    // Hide all steps
    for (let i = 0; i < steps.length; i++) {
      steps[i].style.display = "none";
    }
    // Show the current step
    steps[step].style.display = "block";
    
    // Update the progress bar
    let progress = (step / (steps.length - 1)) * 100;
    progressBar.style.width = progress + "%";
    //progressBar.innerHTML = `Step ${step + 1} of ${steps.length}`;

    // Adjust the button visibility
    if (step == 0) {
      document.getElementById("prevBtn").style.display = "none";
    } else {
      document.getElementById("prevBtn").style.display = "inline";
    }

    if (step == steps.length - 1) {
      document.getElementById("nextBtn").innerHTML = "Submit";
    } else {
      document.getElementById("nextBtn").innerHTML = "Next";
    }
  }

  function nextStep() {
    if (currentStep < steps.length - 1) {
      currentStep++;
      showStep(currentStep);
    } else {
      document.getElementById("multi-step-form").submit(); // Submit the form
    }
  }

  function prevStep() {
    if (currentStep > 0) {
      currentStep--;
      showStep(currentStep);
    }
  }
</script>

	
@endpush
