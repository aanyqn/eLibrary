<!DOCTYPE html>
<html lang="en">
<head>
    @include('general-layout.head')
    @include('general-layout.global_style')
    <link rel="stylesheet" href="/assets/vendors/google/google-sign-in.css">
</head>
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row flex-grow">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-center p-5">

              <div class="brand-logo">
                <img src="../../assets/images/logo.svg">
              </div>

              <h4>Verify Your Account</h4>
              <h6 class="font-weight-light mb-4">
                Enter the 6-digit OTP sent to your email
              </h6>

              <p class="text-muted small">
                {{ auth()->user()->email }}
              </p>

              <form method="POST" action="{{ route('otp.verify') }}" class="pt-3">
                @csrf

                <!-- OTP INPUT BOX -->
                <div class="d-flex justify-content-between mb-4">
                  <input type="text" name="char1" maxlength="1" class="form-control text-center me-2 ps-2 pe-2 otp-input">
                  <input type="text" name="char2" maxlength="1" class="form-control text-center me-2 ps-2 pe-2 otp-input">
                  <input type="text" name="char3" maxlength="1" class="form-control text-center me-2 ps-2 pe-2 otp-input">
                  <input type="text" name="char4" maxlength="1" class="form-control text-center me-2 ps-2 pe-2 otp-input">
                  <input type="text" name="char5" maxlength="1" class="form-control text-center me-2 ps-2 pe-2 otp-input">
                  <input type="text" name="char6" maxlength="1" class="form-control text-center me-2 ps-2 pe-2 otp-input">
                </div>

                <input type="hidden" name="otp" id="otp-value">

                <!-- VERIFY BUTTON -->
                <div class="d-grid mb-3">
                  <button type="submit"
                    class="btn btn-block btn-gradient-primary btn-lg font-weight-medium">
                    VERIFY OTP
                  </button>
                </div>

                <!-- RESEND -->
                <div class="text-center">
                  <small class="text-muted">
                    Didn't receive code?
                  </small>
                  <br>
                  <a href="{{ route('otp.resend') }}" class="text-primary">
                    Resend OTP
                  </a>
                </div>

              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('general-layout.global_js')
</body>
</html>
