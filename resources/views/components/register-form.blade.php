<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
             alt="Your Company">
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your
            account</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <div class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                <div class="mt-2">
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div>
                <label for="firstName" class="block text-sm font-medium leading-6 text-gray-900">First Name</label>
                <div class="mt-2">
                    <input id="firstName" name="firstName" type="text" autocomplete="firstName" required
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div>
                <label for="lastName" class="block text-sm font-medium leading-6 text-gray-900">Last Name</label>
                <div class="mt-2">
                    <input id="lastName" name="lastName" type="text" autocomplete="lastName" required
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div>
                <label for="mobile" class="block text-sm font-medium leading-6 text-gray-900">Mobile</label>
                <div class="mt-2">
                    <input id="mobile" name="mobile" type="tel" autocomplete="mobile" required
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                </div>
                <div class="mt-2">
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div>
                <div class="flex items-center justify-between">
                    <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Confirm
                        Password</label>
                </div>
                <div class="mt-2">
                    <input id="password_confirmation" name="password_confirmation" type="password"
                           autocomplete="new-password" required
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div>
                <button onclick="onRegistration()"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Sign in
                </button>
            </div>
        </div>

        <p class="mt-10 text-center text-sm text-gray-500">
            Already register?
            <a href="{{route('login')}}" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Login</a>
        </p>
    </div>
</div>


<script>
    async function onRegistration() {
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let confirmPassword = document.getElementById('password_confirmation').value;
        let firstName = document.getElementById('firstName').value;
        let lastName = document.getElementById('lastName').value;
        let mobile = document.getElementById('mobile').value;

        let emailFormat = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        let mobileFormat = /^01[1|3-9]\d{8}$/;  //Bangladeshi mobile number format

        if (email === "") {
            errorToast("Email must not be empty");
            return false;
        } else if (!email.match(emailFormat)) {
            errorToast("Please provide a valid email");
            return false;
        } else if (password === "") {
            errorToast("Password must not be empty");
            return false;
        } else if (password.length < 8) {
            errorToast("Password should have a minimum length of 8");
            return false;
        } else if (password !== confirmPassword) {
            errorToast("Password and confirm password do not match");
            return false;
        } else if (firstName === "") {
            errorToast("First name must not be empty");
            return false;
        } else if (lastName === "") {
            errorToast("Last name must not be empty");
            return false;
        } else if (mobile === "" || !mobile.match(mobileFormat) || mobile.length > 13) {
            errorToast("Please provide a valid Bangladeshi mobile number");
            return false;
        } else {
            showLoader();
            try {
                let res = await axios.post("/api/v1/registration", {
                    firstName: firstName,
                    lastName: lastName,
                    email: email,
                    password: password,
                    password_confirmation: confirmPassword,
                    mobile: mobile
                })

                hideLoader();
                if (res.status === 200 && res.data['status'] === "success") {
                    successToast(res.data['message']);
                    setTimeout(() => window.location.href = "/login", 2000);
                } else {
                    errorToast(res.data['message']);
                }
            } catch (error) {
                hideLoader();
                errorToast("An error occurred while processing your request. Please try again.");
            }
        }
    }
</script>
