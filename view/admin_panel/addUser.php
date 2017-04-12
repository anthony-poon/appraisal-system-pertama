<div class='container'>
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
        <form novalidate="true" class='row' action='admin?action=addUserSubmit' method='POST' id='user-wrapper'>
            <div class='container-fluid'>
                <h3>
                    Add user
                </h3>
                <div class='row form-group'>
                    <div class='col-sm-2 col-sm-offset-1'>
                        Username:
                    </div>
                    <div class='col-sm-6'>
                        <input type='text' name='username' class='form-control' required='true'>   
                    </div>
                </div>
                <div class='row form-group'>
                    <div class='col-sm-2 col-sm-offset-1'>
                        Staff Name:
                    </div>
                    <div class='col-sm-6'>
                        <input required='true' type='text' name='staff_name' class='form-control' required='true'>   
                    </div>                
                </div>
                <div class='row form-group'>
                    <div class='col-sm-2 col-sm-offset-1'>
                        Password:
                    </div>                
                    <div class='col-sm-6'>
                        <input required='true' type='text' name='password' class='form-control' value='password' required='true'>   
                    </div>                  
                </div>
                <div class='row form-group'>
                    <input type="submit" class="btn btn-primary btn-sm">
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
