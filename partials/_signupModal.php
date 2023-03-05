
<!-- Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="signupModalLabel">Signup for an iDiscuss Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form action="/forum/partials/_handleSignup.php" method="post">  
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <!-- <input type="email" class="form-control" id="signupEmail" name="signupEmail" aria-describedby="emailHelp" placeholder="Enter email"> -->
            <input required type="email" class="form-control" id="signupEmail" name="signupEmail" aria-describedby="emailHelp" placeholder="Enter your Email">
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input required type="password" class="form-control" id="signupPassword" name="signupPassword" placeholder="Password" minlength="8" maxlength="16" alphabet="A-Za-z0-9+_%@!$*~-"
                 requiredclasses="[A-Z] [a-z] [0-9] [+_%@!$*~-]" requiredclasscount="3"
                 disallowedwords="{{username}}">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1" require>Confirm Password</label>
            <input required type="password" class="form-control" id="signupcPassword" name="signupcPassword" placeholder="Password">
          </div>
          <button type="submit" class="btn btn-primary">SignUp</button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          
        </div>
      </form> 
    </div>
  </div>
</div>