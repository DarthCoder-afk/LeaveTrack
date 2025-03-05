
<form action="" method="POST" id="verifyForm2">
    <div class="modal fade" id="verifyModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Type Current asd</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <input type="password" class="form-control" id="verifyPassword2" placeholder="Password">
                        <div class="input-group-append">
                            <span class="input-group-text" id="togglePassword2">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        </div>
                        
                </div> 
                <small id="passwordHelpBlock" class="form-text text-muted">
                Your password is required to confirm this action.
                </small>    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" id="verifybtn2">Confirm</button>
            </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.getElementById('togglePassword2').addEventListener('click', function (e) {
    const passwordInput = document.getElementById('verifyPassword2');
    const icon = this.querySelector('i');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
});
</script>
