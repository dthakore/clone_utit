		<!-- BACK-TO-TOP -->
		<a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

		<!-- JQUERY JS -->
		<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
		<!-- BOOTSTRAP JS -->
		<script src="{{asset('assets/plugins/bootstrap/js/popper.min.js')}}"></script>
		<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
		<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

		<!-- IONICONS JS -->
		<script src="{{asset('assets/plugins/ionicons/ionicons.js')}}"></script>

		<!-- MOMENT JS -->
		<script src="{{asset('assets/plugins/moment/moment.js')}}"></script>

		<!-- P-SCROLL JS -->
		<script src="{{asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
{{--		<script src="{{asset('assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script>--}}

		<!-- SIDEBAR JS -->
		<script src="{{asset('assets/plugins/side-menu/sidemenu.js')}}"></script>

		<!-- STICKY JS -->
		<script src="{{asset('assets/js/sticky.js')}}"></script>

		<!-- Chart-circle js -->
		<script src="{{asset('assets/plugins/circle-progress/circle-progress.min.js')}}"></script>

		<!-- RIGHT-SIDEBAR JS -->
{{--		<script src="{{asset('assets/plugins/sidebar/sidebar.js')}}"></script>--}}
{{--		<script src="{{asset('assets/plugins/sidebar/sidebar-custom.js')}}"></script>--}}



		<!-- EVA-ICONS JS -->
		<script src="{{asset('assets/plugins/eva-icons/eva-icons.min.js')}}"></script>

		<!-- THEME-COLOR JS -->
		<script src="{{asset('assets/js/themecolor.js')}}"></script>

		<!-- CUSTOM JS -->
		<script src="{{asset('assets/js/custom.js')}}"></script>

		<!-- exported JS -->
		<script src="{{asset('assets/js/exported.js')}}"></script>
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/adminlte.min.js') }}"></script>
        <script src="{{ asset('js/demo.js') }}"></script>
        <script src="{{ asset('js/toastr.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>

        <script src="https://js.pusher.com/7.0.3/pusher.min.js"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.nav-treeview').css('margin-left', '10px');

            //Copy OTP
            function copyReferral() {
                var r = document.createRange();
                r.selectNode(document.getElementById("referral_link"));
                window.getSelection().removeAllRanges();
                window.getSelection().addRange(r);
                document.execCommand('copy');
                window.getSelection().removeAllRanges();
                $('#copied_code').html('Referral Link Copy to Clipboard');
            }

            Pusher.logToConsole = true;
            var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
                cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
            });
            var channel = pusher.subscribe('logoutChannel');
            {{--channel.bind("{{ auth()->user()->api_token }}", function(data) {--}}
                {{--window.location.href = "{{ route('logout') }}";--}}
            {{--});--}}
        </script>
        @yield('scripts')
