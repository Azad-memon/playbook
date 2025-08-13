@extends('web/poster/layout')


@section('body_container')
    <section class="herosec main-searchsec">
        <div class="container">
            <h1 class="herotitle">The Ultimate Job Marketplace</h1>
            <h2 class="herosubtitle">An app for Neighborhoods</h2>
            <p class="herocontent">Discover your next career move with AYN, the go-to job marketplace for job
                seekers and employers.</p>
            <div class="search-bar">
                <span class="search-icon">🔍</span>
                <input type="text" placeholder="Find Gigs in your area" />
                <div class="divider"></div>
                <select class="category-select">
                    <option value="" disabled selected>Select Category</option>
                    <option value="music">Music</option>
                    <option value="comedy">Comedy</option>
                    <option value="theatre">Theatre</option>
                </select>
                <button class="search-btn">Search</button>
            </div>
            <div class="popular_search">
                <p class="popular_search_title">Popular Search:</p>
                <div class="popular_searchs">
                    <span>Sales Executive</span>
                    <span>Cloud Engineer</span>
                    <span>Stack</span>
                    <span>Machine Learning</span>
                    <span>Marketing</span>
                    <span>Customer Support</span>
                    <span>Graphic Designer</span>
                    <span>UI/UX</span>
                    <span>Web Developer</span>
                    <span>Cyber Security</span>
                    <span>Data Analyst</span>
                </div>
            </div>
        </div>
    </section>

    <section class="sponcer">
        <div class="container">
            <div class="spncer_slider">
                <div class="spncer_wraper">
                    <div class="spncer_one">
                        <img src="{{ URL::asset('frontend/assets/img/Company1.png') }}" alt="">
                    </div>
                    <div class="spncer_one">
                        <img src="{{ URL::asset('frontend/assets/img/Company2.png') }}" alt="">
                    </div>
                    <div class="spncer_one">
                        <img src="{{ URL::asset('frontend/assets/img/Company3.png') }}" alt="">
                    </div>
                    <div class="spncer_one">
                        <img src="{{ URL::asset('frontend/assets/img/Company4.png') }}" alt="">
                    </div>
                    <div class="spncer_one">
                        <img src="{{ URL::asset('frontend/assets/img/Company5.png') }}" alt="">
                    </div>
                    <div class="spncer_one">
                        <img src="{{ URL::asset('frontend/assets/img/Company6.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="Gigs">
        <div class="container">
            <div class="gigs_content">
                <h1>Most Recent Gigs</h1>
                <h3>100+ Categories</h3>
                <p>Find the best paying jobs based on the job category. 100% safe recruitment process with transparent
                    progress and real-time assessment.</p>
            </div>
            <div class="gigs_cards row">
                <div class="col-lg-3">
                    <div class="gigs_card ">
                        <h6>Senior UI Designer</h6>
                        <div class="card_icon">
                            <img src="{{ URL::asset('frontend/assets/img/Logo_placeholder.png') }}" alt="">
                            <p>Creative Solutions, Inc.</p>
                        </div>
                        <div class="gig_time">
                            <a href="{{ route('login') }}" class="card_time">Full Time</a>
                        </div>
                        <ul>
                            <li>Bachelor's degree in design or related</li>
                            <li>5+ years of experience in UI design</li>
                            <li>Proficiency in Adobe Creative Suite</li>



                        </ul>
                        <div class="card_location">
                            <img src="{{ URL::asset('frontend/assets/img/Location_Icon.png') }}" alt="">
                            <p>San Fransisco, CA</p>
                        </div>
                        <div class="card_prize">
                            <img src="{{ URL::asset('frontend/assets/img/Money_Icon.png') }}" alt="">
                            <p>90,000 - 120,000 per year</p>
                        </div>
                        <div class="apply_job">
                            <a href="{{ route('login') }}">Apply This Job</a>
                            <img src="{{ URL::asset('frontend/assets/img/Save_Icon.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="gigs_card">
                        <h6>UI/UX Designer</h6>
                        <div class="card_icon">
                            <img src="{{ URL::asset('frontend/assets/img/Logo_placeholder.png') }}" alt="">
                            <p>Acme Corporation</p>
                        </div>
                        <div class="gig_time">
                            <a href="{{ route('login') }}" class="card_time">Full Time</a>
                        </div>
                        <ul>
                            <li>Bachelor's degree in design or related</li>
                            <li>5+ years of experience in UI design</li>
                            <li>Proficiency in Adobe Creative Suite</li>
                        </ul>
                        <div class="card_location">
                            <img src="{{ URL::asset('frontend/assets/img/Location_Icon.png') }}" alt="">
                            <p>New York, NY</p>
                        </div>
                        <div class="card_prize">
                            <img src="{{ URL::asset('frontend/assets/img/Money_Icon.png') }}" alt="">
                            <p>80,000 - 100,000 per year</p>
                        </div>
                        <div class="apply_job">
                            <a href="{{ route('login') }}">Apply This Job</a>
                            <img src="{{ URL::asset('frontend/assets/img/Save_Icon.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="gigs_card">
                        <h6>Mobile UI Designer</h6>
                        <div class="card_icon">
                            <img src="{{ URL::asset('frontend/assets/img/Logo_placeholder.png') }}" alt="">
                            <p>App Works</p>
                        </div>
                        <div class="gig_time">
                            <a href="{{ route('login') }}" class="card_time">Full Time</a>
                        </div>
                        <ul>
                            <li>Bachelor's degree in design or related</li>
                            <li>5+ years of experience in UI design</li>
                            <li>Proficiency in Adobe Creative Suite</li>
                        </ul>
                        <div class="card_location">
                            <img src="{{ URL::asset('frontend/assets/img/Location_Icon.png') }}" alt="">
                            <p>Los Angeles, CA</p>
                        </div>
                        <div class="card_prize">
                            <img src="{{ URL::asset('frontend/assets/img/Money_Icon.png') }}" alt="">
                            <p>70,000 - 90,000 per year</p>
                        </div>
                        <div class="apply_job">
                            <a href="{{ route('login') }}">Apply This Job</a>
                            <img src="{{ URL::asset('frontend/assets/img/Save_Icon.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="gigs_card">
                        <h6>Lead UI/UX Designer</h6>
                        <div class="card_icon">
                            <img src="{{ URL::asset('frontend/assets/img/Logo_placeholder.png') }}" alt="">
                            <p>UXLabs Company</p>
                        </div>
                        <div class="gig_time">
                            <a href="{{ route('login') }}" class="card_time">Full Time</a>
                        </div>
                        <ul>
                            <li>Bachelor's degree in design or related</li>
                            <li>5+ years of experience in UI design</li>
                            <li>Proficiency in Adobe Creative Suite</li>
                        </ul>
                        <div class="card_location">
                            <img src="{{ URL::asset('frontend/assets/img/Location_Icon.png') }}" alt="">
                            <p>Chicago, IL</p>
                        </div>
                        <div class="card_prize">
                            <img src="{{ URL::asset('frontend/assets/img/Money_Icon.png') }}" alt="">
                            <p>100,000 - 130,000 per year</p>
                        </div>
                        <div class="apply_job">
                            <a href="{{ route('login') }}">Apply This Job</a>
                            <img src="{{ URL::asset('frontend/assets/img/Save_Icon.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="gigs_btn">
                    <button><a href="{{ route('login') }}">View All Popular Jobs</a></button>
                </div>
            </div>
    </section>

    <section>
        <div class="container career">
            <h1>Ready to take the next step in your career?</h1>
            <p class="text-white" style="opacity: 0.7;">Join AYN today and start exploring exciting job opportunities with
                top companies.</p>
            <div class="con-buttons">
                <a href="{{ route('login') }}" class="con">Contact Us</a>
                <a href="{{ route('login') }}" class="learn">Learn More</a>
            </div>
        </div>
    </section>

    <section class="jobs">
        <div class="container">
            <div class="jobs_heading">
                <h1>Explore our Job Categories</h1>
                <p>Get started by looking at our job categories. Hundreds of new jobs everyday!</p>
            </div>
            <div class="jobs_cards row">
                <div class="col-lg-3">
                    <div class="job_card">
                        <div class="job_card_img">
                            <img src="{{ URL::asset('frontend/assets/img/it.png') }}" alt="">
                        </div>
                        <div class="job_title">
                            <h5>IT Development</h5>
                            <p>3,450 open jobs</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="job_card">
                        <div class="job_card_img">
                            <img src="{{ URL::asset('frontend/assets/img/it.png') }}" alt="">
                        </div>
                        <div class="job_title">
                            <h5>Finance</h5>
                            <p>1,965 open jobs</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="job_card">
                        <div class="job_card_img">
                            <img src="{{ URL::asset('frontend/assets/img/it.png') }}" alt="">
                        </div>
                        <div class="job_title">
                            <h5>Healthcare</h5>
                            <p>2,812 open jobs</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="job_card">
                        <div class="job_card_img">
                            <img src="{{ URL::asset('frontend/assets/img/it.png') }}" alt="">
                        </div>
                        <div class="job_title">
                            <h5>Sales & Marketing</h5>
                            <p>2,198 open jobs</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="jobs_cards row row-two">
                <div class="col-lg-3">
                    <div class="job_card">
                        <div class="job_card_img">
                            <img src="{{ URL::asset('frontend/assets/img/it.png') }}" alt="">
                        </div>
                        <div class="job_title">
                            <h5>Education</h5>
                            <p>1,511 open jobs</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="job_card">
                        <div class="job_card_img">
                            <img src="{{ URL::asset('frontend/assets/img/it.png') }}" alt="">
                        </div>
                        <div class="job_title">
                            <h5>Design</h5>
                            <p>2,988 open jobs</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="job_card">
                        <div class="job_card_img">
                            <img src="{{ URL::asset('frontend/assets/img/it.png') }}" alt="">
                        </div>
                        <div class="job_title">
                            <h5>Research</h5>
                            <p>1,233 open jobs</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="job_card">
                        <div class="job_card_img">
                            <img src="{{ URL::asset('frontend/assets/img/it.png') }}" alt="">
                        </div>
                        <div class="job_title">
                            <h5>Human Resources</h5>
                            <p>1,836 open jobs</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>



    <section>
        <div class="container join">
            <h1>Join AYN today and take the first step towards finding your dream job!</h1>
            <p>With our user-friendly platform and up-to-date job listings, you'll be on your way to a fulfilling career in
                no time. Sign up now and see what opportunities await!</p>

            <a href="{{ route('login') }}" class="join-btn">Join Now</a>

        </div>
    </section>


    <section class="top-users">
        <div class="container">
            <div class="users_heading">
                <h1>Top Rated by Users</h1>
                <p>Explore and find the dream job opportunities with our best companies and employers.</p>
            </div>
            <div class="users_cards">
                <div class="users-row-one row">
                    <div class="col-lg-3">
                        <div class="user_card ">
                            <div class="user_card_main">
                                <div class="user-card_img">
                                    <img src="{{ URL::asset('frontend/assets/img/userlogo.png') }}" alt="">
                                </div>
                                <div class="user_card_title">
                                    <h6>TechWorks Incorporation</h6>
                                    <img src="{{ URL::asset('frontend/assets/img/stars.png') }}" alt="">
                                </div>
                            </div>
                            <div class="user_card_details">
                                <div class="employees">
                                    <img src="{{ URL::asset('frontend/assets/img/user_icon.png') }}" alt="">
                                    <p>1,235 employees</p>
                                </div>
                                <div class="user-open_jobs">
                                    <p>10 jobs open</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="user_card ">
                            <div class="user_card_main">
                                <div class="user-card_img">
                                    <img src="{{ URL::asset('frontend/assets/img/userlogo.png') }}" alt="">
                                </div>
                                <div class="user_card_title">
                                    <h6>TechWorks Incorporation</h6>
                                    <img src="{{ URL::asset('frontend/assets/img/stars.png') }}" alt="">
                                </div>
                            </div>
                            <div class="user_card_details">
                                <div class="employees">
                                    <img src="{{ URL::asset('frontend/assets/img/user_icon.png') }}" alt="">
                                    <p>1,235 employees</p>
                                </div>
                                <div class="user-open_jobs">
                                    <p>10 jobs open</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="user_card ">
                            <div class="user_card_main">
                                <div class="user-card_img">
                                    <img src="{{ URL::asset('frontend/assets/img/userlogo.png') }}" alt="">
                                </div>
                                <div class="user_card_title">
                                    <h6>TechWorks Incorporation</h6>
                                    <img src="{{ URL::asset('frontend/assets/img/stars.png') }}" alt="">
                                </div>
                            </div>
                            <div class="user_card_details">
                                <div class="employees">
                                    <img src="{{ URL::asset('frontend/assets/img/user_icon.png') }}" alt="">
                                    <p>1,235 employees</p>
                                </div>
                                <div class="user-open_jobs">
                                    <p>10 jobs open</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="user_card ">
                            <div class="user_card_main">
                                <div class="user-card_img">
                                    <img src="{{ URL::asset('frontend/assets/img/userlogo.png') }}" alt="">
                                </div>
                                <div class="user_card_title">
                                    <h6>TechWorks Incorporation</h6>
                                    <img src="{{ URL::asset('frontend/assets/img/stars.png') }}" alt="">
                                </div>
                            </div>
                            <div class="user_card_details">
                                <div class="employees">
                                    <img src="{{ URL::asset('frontend/assets/img/user_icon.png') }}" alt="">
                                    <p>1,235 employees</p>
                                </div>
                                <div class="user-open_jobs">
                                    <p>10 jobs open</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="users-row-two row">
                    <div class="col-lg-3">
                        <div class="user_card ">
                            <div class="user_card_main">
                                <div class="user-card_img">
                                    <img src="{{ URL::asset('frontend/assets/img/userlogo.png') }}" alt="">
                                </div>
                                <div class="user_card_title">
                                    <h6>TechWorks Incorporation</h6>
                                    <img src="{{ URL::asset('frontend/assets/img/stars.png') }}" alt="">
                                </div>
                            </div>
                            <div class="user_card_details">
                                <div class="employees">
                                    <img src="{{ URL::asset('frontend/assets/img/user_icon.png') }}" alt="">
                                    <p>1,235 employees</p>
                                </div>
                                <div class="user-open_jobs">
                                    <p>10 jobs open</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="user_card ">
                            <div class="user_card_main">
                                <div class="user-card_img">
                                    <img src="{{ URL::asset('frontend/assets/img/userlogo.png') }}" alt="">
                                </div>
                                <div class="user_card_title">
                                    <h6>TechWorks Incorporation</h6>
                                    <img src="{{ URL::asset('frontend/assets/img/stars.png') }}" alt="">
                                </div>
                            </div>
                            <div class="user_card_details">
                                <div class="employees">
                                    <img src="{{ URL::asset('frontend/assets/img/user_icon.png') }}" alt="">
                                    <p>1,235 employees</p>
                                </div>
                                <div class="user-open_jobs">
                                    <p>10 jobs open</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="user_card ">
                            <div class="user_card_main">
                                <div class="user-card_img">
                                    <img src="{{ URL::asset('frontend/assets/img/userlogo.png') }}" alt="">
                                </div>
                                <div class="user_card_title">
                                    <h6>TechWorks Incorporation</h6>
                                    <img src="{{ URL::asset('frontend/assets/img/stars.png') }}" alt="">
                                </div>
                            </div>
                            <div class="user_card_details">
                                <div class="employees">
                                    <img src="{{ URL::asset('frontend/assets/img/user_icon.png') }}" alt="">
                                    <p>1,235 employees</p>
                                </div>
                                <div class="user-open_jobs">
                                    <p>10 jobs open</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="user_card ">
                            <div class="user_card_main">
                                <div class="user-card_img">
                                    <img src="{{ URL::asset('frontend/assets/img/userlogo.png') }}" alt="">
                                </div>
                                <div class="user_card_title">
                                    <h6>TechWorks Incorporation</h6>
                                    <img src="{{ URL::asset('frontend/assets/img/stars.png') }}" alt="">
                                </div>
                            </div>
                            <div class="user_card_details">
                                <div class="employees">
                                    <img src="{{ URL::asset('frontend/assets/img/user_icon.png') }}" alt="">
                                    <p>1,235 employees</p>
                                </div>
                                <div class="user-open_jobs">
                                    <p>10 jobs open</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uesrs_btn">
                <button><a href="{{ route('login') }}">View All Top Companies</a></button>
            </div>
        </div>
    </section>
@endsection
