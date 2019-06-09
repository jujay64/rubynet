<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <title>Register - Rubynet</title>

    <script type='text/javascript'>
       window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
</head>
<body>
    <div class="grid-x align-center">
        <div class="row column align-center medium-6 large-4 container-padded">
            <form class="register-form" method="POST" action="{{ route('register') }}">
               {{ csrf_field() }}
               <h4 class="text-center">Rubynet Register</h4>
               @if(!empty($errors->first()))
                <div class="row col-lg-12">
                    <div class="callout alert">
                    {{ $errors->first() }}
                    </div>
                </div>
                @endif
                @if (session('status'))
                <div class="callout success">
                     {{ session('status') }}
                </div>
                @endif
                @if (session('warning'))
                <div class="callout warning">
                    {{ session('warning') }}
                </div>
                @endif
               <label>Last Name (Kanji)
                  <input id="lastname" type="text" placeholder="Last Name" name="lastName" value="{{ old('lastName') }}"  required autofocus>
              </label>  
              <label>First Name (Kanji)
                  <input id="firstname" type="text" placeholder="First Name" name="firstName" value="{{ old('firstName') }}" required>
              </label>
              <label>Last Name (Kana)
                  <input id="lastnamekana" type="text" placeholder="Last Name Kana" name="lastNameKana" value="{{ old('lastNameKana') }}" required>
              </label>
              <label>First Name (Kana)
                  <input id="firstnamekana" type="text" placeholder="First Name Kana" name="firstNameKana" value="{{ old('firstNameKana') }}" required>
              </label>
              <label>Email
                <input type="email" id="email" name="email" placeholder="E-Mail Address" value="{{ old('email') }}" required>
            </label>
            <label>Password
                <input type="password" id="password" name="password" placeholder="Password" required>
            </label>
           <label>Confirm Password
                <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password" required>
           </label>
           <label>Department
           <select id="department" name="department" class="form-control" value="{{ old('department') }}" required>
              <option value="">Select your department</option>
              @foreach($departments as $key => $department)
              <option value="{!! $department['id'] !!}" {{ (old('department') == $department['id'] ? "selected":"") }}>{!! $department['name'] !!}</option>
              @endforeach
            </select>
           </label>
           <label>Job
           <select id="job" name="job" class="form-control" value="{{ old('job') }}" required>
              <option value="">Select your job</option>
              @foreach($jobs as $key => $job)
              <option value="{!! $job['id'] !!}" {{ (old('job') == $job['id'] ? "selected":"") }}>{!! $job['name'] !!}</option>
              @endforeach
            </select>
           </label>
           <label>Role
           <select id="role" name="role" class="form-control" required>
              <option value="">Select your role</option>
              @foreach($roles as $key => $role)
              <option value="{!! $role['id'] !!}" {{ (old('role') == $role['id'] ? "selected":"") }}>{!! $role['name'] !!}</option>
              @endforeach
            </select>
           </label>        
           <label>Entry Date 
             <input id="datepicker" type="text" name="entryDate" value="{{ old('entryDate') }}" required>
           </label>  
           <p><input class="button expanded" type="submit" value="Sign up"></p>
           <p class="text-center">Already have an account? <a href="{{ route('login') }}">Go to login page <i class="fi-arrow-right"></i></a></p>
       </form>
   </div>
</div>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#datepicker" ).datepicker({
      dateFormat: 'yy/mm/dd'
    });
  });
</script>
</body>
</html>
