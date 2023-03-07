@extends('pub.message-center.layouts.message-center')

@push('styles-header')
    <link rel="stylesheet" href="https://unpkg.com/simplebar@latest/dist/simplebar.css" />
@endpush
@section('page-content')

    <button type="button" id="message-center__toggle-button" class="message-center__toggle-button"> &lt; Back To Conversations</button>
    <section class="message-center">
        <aside class="message-center__sidebar">
            <div class="message-center__sidebar-wrapper" id="conversations_sidebar">
                <ul class="conversations">
                    <li  class="conversations__tab">

                        <div class="conversations__tab-avatar-container">
                            <img class="conversations__tab-avatar" src="https://placehold.it/300x300">
                        </div>

                        <div class="conversations__tab-content-container">
                            <span class="conversations__tab-content-recipient util-block">Jane Doe</span>
                            <span class="conversations__tab-content-subject util-block">Lorem ipsum dolar sit amet</span>
                            <!-- 							<span class="conversations__tab-content-type util-block">User Type</span>
                                                        <span class="conversations__tab-content-location util-block">New York, New York</span> -->
                            <span class="conversations__tab-content-badge badge">3</span>
                        </div>

                    </li>
                    <li  class="conversations__tab">

                        <div class="conversations__tab-avatar-container">
                            <img class="conversations__tab-avatar" src="https://placehold.it/300x300">
                        </div>

                        <div class="conversations__tab-content-container">
                            <span class="conversations__tab-content-recipient util-block">John Doe</span>
                            <span class="conversations__tab-content-subject util-block">Lorem ipsum dolar sit amet</span>
                            <!-- 							<span class="conversations__tab-content-type util-block">User Type</span>
                                                        <span class="conversations__tab-content-location util-block">New York, New York</span> -->
                            <span class="conversations__tab-content-badge badge">2</span>
                        </div>

                    </li>
                    <li  class="conversations__tab">

                        <div class="conversations__tab-avatar-container">
                            <img class="conversations__tab-avatar" src="https://placehold.it/300x300">
                        </div>

                        <div class="conversations__tab-content-container">
                            <span class="conversations__tab-content-recipient util-block">Jane Doe</span>
                            <span class="conversations__tab-content-subject util-block">Lorem ipsum dolar sit amet</span>
                            <!-- 							<span class="conversations__tab-content-type util-block">User Type</span>
                                                        <span class="conversations__tab-content-location util-block">New York, New York</span> -->
                            <span class="conversations__tab-content-badge badge">3</span>
                        </div>

                    </li>
                    <li  class="conversations__tab">

                        <div class="conversations__tab-avatar-container">
                            <img class="conversations__tab-avatar" src="https://placehold.it/300x300">
                        </div>

                        <div class="conversations__tab-content-container">
                            <span class="conversations__tab-content-recipient util-block">John Doe</span>
                            <span class="conversations__tab-content-subject util-block">Lorem ipsum dolar sit amet</span>
                            <!-- 							<span class="conversations__tab-content-type util-block">User Type</span>
                                                        <span class="conversations__tab-content-location util-block">New York, New York</span> -->
                            <span class="conversations__tab-content-badge badge">2</span>
                        </div>

                    </li>
                    <li  class="conversations__tab">

                        <div class="conversations__tab-avatar-container">
                            <img class="conversations__tab-avatar" src="https://placehold.it/300x300">
                        </div>

                        <div class="conversations__tab-content-container">
                            <span class="conversations__tab-content-recipient util-block">Jane Doe</span>
                            <span class="conversations__tab-content-subject util-block">Lorem ipsum dolar sit amet</span>
                            <!-- 							<span class="conversations__tab-content-type util-block">User Type</span>
                                                        <span class="conversations__tab-content-location util-block">New York, New York</span> -->
                            <span class="conversations__tab-content-badge badge">3</span>
                        </div>

                    </li>
                    <li  class="conversations__tab">

                        <div class="conversations__tab-avatar-container">
                            <img class="conversations__tab-avatar" src="https://placehold.it/300x300">
                        </div>

                        <div class="conversations__tab-content-container">
                            <span class="conversations__tab-content-recipient util-block">John Doe</span>
                            <span class="conversations__tab-content-subject util-block">Lorem ipsum dolar sit amet</span>
                            <!-- 							<span class="conversations__tab-content-type util-block">User Type</span>
                                                        <span class="conversations__tab-content-location util-block">New York, New York</span> -->
                            <span class="conversations__tab-content-badge badge">2</span>
                        </div>

                    </li>
                    <li  class="conversations__tab">

                        <div class="conversations__tab-avatar-container">
                            <img class="conversations__tab-avatar" src="https://placehold.it/300x300">
                        </div>

                        <div class="conversations__tab-content-container">
                            <span class="conversations__tab-content-recipient util-block">Jane Doe</span>
                            <span class="conversations__tab-content-subject util-block">Lorem ipsum dolar sit amet</span>
                            <!-- 							<span class="conversations__tab-content-type util-block">User Type</span>
                                                        <span class="conversations__tab-content-location util-block">New York, New York</span> -->
                            <span class="conversations__tab-content-badge badge">3</span>
                        </div>

                    </li>
                    <li  class="conversations__tab">

                        <div class="conversations__tab-avatar-container">
                            <img class="conversations__tab-avatar" src="https://placehold.it/300x300">
                        </div>

                        <div class="conversations__tab-content-container">
                            <span class="conversations__tab-content-recipient util-block">John Doe</span>
                            <span class="conversations__tab-content-subject util-block">Lorem ipsum dolar sit amet</span>
                            <!-- 							<span class="conversations__tab-content-type util-block">User Type</span>
                                                        <span class="conversations__tab-content-location util-block">New York, New York</span> -->
                            <span class="conversations__tab-content-badge badge">2</span>
                        </div>

                    </li>

                    <li  class="conversations__tab">

                        <div class="conversations__tab-avatar-container">
                            <img class="conversations__tab-avatar" src="https://placehold.it/300x300">
                        </div>

                        <div class="conversations__tab-content-container">
                            <span class="conversations__tab-content-recipient util-block">Jane Doe</span>
                            <span class="conversations__tab-content-subject util-block">Lorem ipsum dolar sit amet</span>
                            <!-- 							<span class="conversations__tab-content-type util-block">User Type</span>
                                                        <span class="conversations__tab-content-location util-block">New York, New York</span> -->
                            <span class="conversations__tab-content-badge badge">3</span>
                        </div>

                    </li>
                    <li  class="conversations__tab">

                        <div class="conversations__tab-avatar-container">
                            <img class="conversations__tab-avatar" src="https://placehold.it/300x300">
                        </div>

                        <div class="conversations__tab-content-container">
                            <span class="conversations__tab-content-recipient util-block">John Doe</span>
                            <span class="conversations__tab-content-subject util-block">Lorem ipsum dolar sit amet</span>
                            <!-- 							<span class="conversations__tab-content-type util-block">User Type</span>
                                                        <span class="conversations__tab-content-location util-block">New York, New York</span> -->
                            <span class="conversations__tab-content-badge badge">2</span>
                        </div>

                    </li>
                    <li  class="conversations__tab">

                        <div class="conversations__tab-avatar-container">
                            <img class="conversations__tab-avatar" src="https://placehold.it/300x300">
                        </div>

                        <div class="conversations__tab-content-container">
                            <span class="conversations__tab-content-recipient util-block">Jane Doe</span>
                            <span class="conversations__tab-content-subject util-block">Lorem ipsum dolar sit amet</span>
                            <!-- 							<span class="conversations__tab-content-type util-block">User Type</span>
                                                        <span class="conversations__tab-content-location util-block">New York, New York</span> -->
                            <span class="conversations__tab-content-badge badge">3</span>
                        </div>

                    </li>
                    <li  class="conversations__tab">

                        <div class="conversations__tab-avatar-container">
                            <img class="conversations__tab-avatar" src="https://placehold.it/300x300">
                        </div>

                        <div class="conversations__tab-content-container">
                            <span class="conversations__tab-content-recipient util-block">John Doe</span>
                            <span class="conversations__tab-content-subject util-block">Lorem ipsum dolar sit amet</span>
                            <!-- 							<span class="conversations__tab-content-type util-block">User Type</span>
                                                        <span class="conversations__tab-content-location util-block">New York, New York</span> -->
                            <span class="conversations__tab-content-badge badge">2</span>
                        </div>

                    </li>
                    <li  class="conversations__tab">

                        <div class="conversations__tab-avatar-container">
                            <img class="conversations__tab-avatar" src="https://placehold.it/300x300">
                        </div>

                        <div class="conversations__tab-content-container">
                            <span class="conversations__tab-content-recipient util-block">Jane Doe</span>
                            <span class="conversations__tab-content-subject util-block">Lorem ipsum dolar sit amet</span>
                            <!-- 							<span class="conversations__tab-content-type util-block">User Type</span>
                                                        <span class="conversations__tab-content-location util-block">New York, New York</span> -->
                            <span class="conversations__tab-content-badge badge">3</span>
                        </div>

                    </li>
                    <li  class="conversations__tab">

                        <div class="conversations__tab-avatar-container">
                            <img class="conversations__tab-avatar" src="https://placehold.it/300x300">
                        </div>

                        <div class="conversations__tab-content-container">
                            <span class="conversations__tab-content-recipient util-block">John Doe</span>
                            <span class="conversations__tab-content-subject util-block">Lorem ipsum dolar sit amet</span>
                            <!-- 							<span class="conversations__tab-content-type util-block">User Type</span>
                                                        <span class="conversations__tab-content-location util-block">New York, New York</span> -->
                            <span class="conversations__tab-content-badge badge">2</span>
                        </div>

                    </li>
                    <li  class="conversations__tab">

                        <div class="conversations__tab-avatar-container">
                            <img class="conversations__tab-avatar" src="https://placehold.it/300x300">
                        </div>

                        <div class="conversations__tab-content-container">
                            <span class="conversations__tab-content-recipient util-block">Jane Doe</span>
                            <span class="conversations__tab-content-subject util-block">Lorem ipsum dolar sit amet</span>
                            <!-- 							<span class="conversations__tab-content-type util-block">User Type</span>
                                                        <span class="conversations__tab-content-location util-block">New York, New York</span> -->
                            <span class="conversations__tab-content-badge badge">3</span>
                        </div>

                    </li>
                    <li  class="conversations__tab">

                        <div class="conversations__tab-avatar-container">
                            <img class="conversations__tab-avatar" src="https://placehold.it/300x300">
                        </div>

                        <div class="conversations__tab-content-container">
                            <span class="conversations__tab-content-recipient util-block">John Doe</span>
                            <span class="conversations__tab-content-subject util-block">Lorem ipsum dolar sit amet</span>
                            <!-- 							<span class="conversations__tab-content-type util-block">User Type</span>
                                                        <span class="conversations__tab-content-location util-block">New York, New York</span> -->
                            <span class="conversations__tab-content-badge badge">2</span>
                        </div>

                    </li>
                </ul>
            </div>
        </aside>
        <section class="message-center__conversation messages">
            <header class="messages-header">

                <div class="messages-header__avatar-container">
                    <img class="messages-header__avatar" src="https://placehold.it/300x300" />
                </div>
                <div class="messages-header__content">
                    <h3 class="messages-header__recipient">Jane Doe</h3>
                    <span class="messages-header__user-type">Realtor</span>
                    <a href="#" class="messages-header__profile-link">View Profile</a>

                    <span class="messages-header__subject"><strong>Subject:</strong> This is the title of the conversation</span>
                </div>
            </header>
            <section class="messages-body" id="messages-body">

                <ul class="messages-list" id="messages-list">
                    <li class="messages-list__item messages-list__item--self">
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="messages-list__item-author util-block">Me</span>
                            </div>
                            <div class="col-sm-6">
                                <span class="messages-list__item-timestamp util-block text-right">July 12, 2017 at 3:13 PM</span>
                            </div>
                        </div>
                        <div class="messages-list__item-content">
                            <p>Vel nostrum conceptam honestatis te. Ea
                                doctus vidisse quo, in sale dolor singulis
                                qui. Id numquam tincidunt scriptorem vis,
                                summo impedit fastidii eos ea.<p>
                        </div>
                    </li>
                    <li class="messages-list__item messages-list__item--recipient">
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="messages-list__item-author util-block">Jane Doe</span>
                            </div>
                            <div class="col-sm-6">
                                <span class="messages-list__item-timestamp util-block text-right">July 12, 2017 at 3:13 PM</span>
                            </div>
                        </div>


                        <div class="messages-list__item-content">
                            <p>Vel nostrum conceptam honestatis te. Ea
                                doctus vidisse quo, in sale dolor singulis
                                qui. Id numquam tincidunt scriptorem vis,
                                summo impedit fastidii eos ea. Nec ea
                                postea ocurreret.<p>

                            <p>Ex dico sanctus est, ex nihil possit eum,
                                nec ad tale accusamus. Eirmod eloquentiam
                                pro ea, luptatum pericula mei ne. Amet
                                probatus cu pro.</p>
                        </div>
                    </li>
                    <li class="messages-list__item messages-list__item--recipient">
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="messages-list__item-author util-block">Jane Doe</span>
                            </div>
                            <div class="col-sm-6">
                                <span class="messages-list__item-timestamp util-block text-right">July 12, 2017 at 3:13 PM</span>
                            </div>
                        </div>


                        <div class="messages-list__item-content">
                            <p>Vel nostrum conceptam honestatis te. Ea
                                doctus vidisse quo, in sale dolor singulis
                                qui. Id numquam tincidunt scriptorem vis,
                                summo impedit fastidii eos ea. Nec ea
                                postea ocurreret.<p>

                            <p>Ex dico sanctus est, ex nihil possit eum,
                                nec ad tale accusamus. Eirmod eloquentiam
                                pro ea, luptatum pericula mei ne. Amet
                                probatus cu pro.</p>
                        </div>
                    </li>
                    <li class="messages-list__item messages-list__item--self">
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="messages-list__item-author util-block">Me</span>
                            </div>
                            <div class="col-sm-6">
                                <span class="messages-list__item-timestamp util-block text-right">July 12, 2017 at 3:13 PM</span>
                            </div>
                        </div>
                        <div class="messages-list__item-content">
                            <p>Vel nostrum conceptam honestatis te. Ea
                                doctus vidisse quo, in sale dolor singulis
                                qui. Id numquam tincidunt scriptorem vis,
                                summo impedit fastidii eos ea.<p>
                        </div>
                    </li>
                    <li class="messages-list__item messages-list__item--recipient">
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="messages-list__item-author util-block">Jane Doe</span>
                            </div>
                            <div class="col-sm-6">
                                <span class="messages-list__item-timestamp util-block text-right">July 12, 2017 at 3:13 PM</span>
                            </div>
                        </div>


                        <div class="messages-list__item-content">
                            <p>Vel nostrum conceptam honestatis te. Ea
                                doctus vidisse quo, in sale dolor singulis
                                qui. Id numquam tincidunt scriptorem vis,
                                summo impedit fastidii eos ea. Nec ea
                                postea ocurreret.<p>

                            <p>Ex dico sanctus est, ex nihil possit eum,
                                nec ad tale accusamus. Eirmod eloquentiam
                                pro ea, luptatum pericula mei ne. Amet
                                probatus cu pro.</p>
                        </div>
                    </li>
                    <li class="messages-list__item messages-list__item--self">
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="messages-list__item-author util-block">Me</span>
                            </div>
                            <div class="col-sm-6">
                                <span class="messages-list__item-timestamp util-block text-right">July 12, 2017 at 3:13 PM</span>
                            </div>
                        </div>
                        <div class="messages-list__item-content">
                            <p>Vel nostrum conceptam honestatis te. Ea
                                doctus vidisse quo, in sale dolor singulis
                                qui. Id numquam tincidunt scriptorem vis,
                                summo impedit fastidii eos ea.<p>
                        </div>
                    </li>
                    <li class="messages-list__item messages-list__item--self">
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="messages-list__item-author util-block">Me</span>
                            </div>
                            <div class="col-sm-6">
                                <span class="messages-list__item-timestamp util-block text-right">July 12, 2017 at 3:13 PM</span>
                            </div>
                        </div>
                        <div class="messages-list__item-content">
                            <p>Vel nostrum conceptam honestatis te. Ea
                                doctus vidisse quo, in sale dolor singulis
                                qui. Id numquam tincidunt scriptorem vis,
                                summo impedit fastidii eos ea.<p>
                        </div>
                    </li>
                    <li class="messages-list__item messages-list__item--recipient">
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="messages-list__item-author util-block">Jane Doe</span>
                            </div>
                            <div class="col-sm-6">
                                <span class="messages-list__item-timestamp util-block text-right">July 12, 2017 at 3:13 PM</span>
                            </div>
                        </div>


                        <div class="messages-list__item-content">
                            <p>Vel nostrum conceptam honestatis te. Ea
                                doctus vidisse quo, in sale dolor singulis
                                qui. Id numquam tincidunt scriptorem vis,
                                summo impedit fastidii eos ea. Nec ea
                                postea ocurreret.<p>

                            <p>Ex dico sanctus est, ex nihil possit eum,
                                nec ad tale accusamus. Eirmod eloquentiam
                                pro ea, luptatum pericula mei ne. Amet
                                probatus cu pro.</p>
                        </div>
                    </li>
                    <li class="messages-list__item messages-list__item--self">
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="messages-list__item-author util-block">Me</span>
                            </div>
                            <div class="col-sm-6">
                                <span class="messages-list__item-timestamp util-block text-right">July 12, 2017 at 3:13 PM</span>
                            </div>
                        </div>
                        <div class="messages-list__item-content">
                            <p>Vel nostrum conceptam honestatis te. Ea
                                doctus vidisse quo, in sale dolor singulis
                                qui. Id numquam tincidunt scriptorem vis,
                                summo impedit fastidii eos ea.<p>
                        </div>
                    </li>
                </ul>

            </section>
            <footer class="messages-footer">
                <div class="messages-footer__input-container input-group">

                    <input type="text" class="messages-footer__input form-control" placeholder="Type your message here">
                    <span class="input-group-btn">
						<button class="btn messages-footer__submit" type="button">Send</button>
					</span>
                </div>
            </footer>
        </section>
    </section>


@endsection

@push('scripts-footer')
    <script src="https://unpkg.com/simplebar@latest/dist/simplebar.js"></script>
    <script>
	    $(document).ready(() => {
		    const $toggleButton = $('#message-center__toggle-button')
		    const $messageSidebar = $('.message-center__sidebar')
		    const $conversations  = $('.conversations__tab')

		    $toggleButton.on('click', function(e) {
			    toggleSidebar()
		    })

		    $conversations.on('click', function(e) {
			    toggleSidebar()
		    })

		    const toggleSidebar = () => {
			    $messageSidebar.toggleClass('message-center__sidebar--active')
		    }

		    new SimpleBar($('#conversations_sidebar')[0], {

		    })

		    new SimpleBar($('#messages-body')[0], {

		    })

	    })
    </script>
@endpush