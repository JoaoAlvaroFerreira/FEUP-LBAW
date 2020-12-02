@include('layouts.header')

@include('layouts.navbar')
    
    
    <br></br>
    <div class="container py-3">
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="accordion" id="faqExample">
                    <div class="card">
                        <div class="card-header p-2" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                  Q: What is Meetcamp?
                                </button>
                              </h5>
                        </div>
    
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqExample">
                            <div class="card-body">
                                <b>Answer:</b> Meetcamp is an online platform that can be used to create and manage events.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header p-2" id="headingTwo">
                            <h5 class="mb-0">
                            <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                              Q: What kind of events can I create?
                            </button>
                          </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqExample">
                            <div class="card-body">
                              <b>Answer:</b> Any at all! Let your imagination run wild!
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header p-2" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                  Q. Can i create events that require payment to attend?
                                </button>
                              </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqExample">
                            <div class="card-body">
                              <b>Answer:</b> Yes, a price field is available to fill when you create an event.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header p-2" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                  Q. Can I invite anyone to my events?
                                </button>
                              </h5>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingThree" data-parent="#faqExample">
                            <div class="card-body">
                              <b>Answer:</b> You can do so at anytime on your event page. 
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>
        </div>
        <!--/row-->
    </div>
    <!--container-->


    @include('layouts.footer')