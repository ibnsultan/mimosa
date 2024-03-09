function changeButtonState(button, state){
    if(state === 'loading'){
        button.setAttribute('disabled', 'true');
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
    }else if(state === 'reset'){
        button.removeAttribute('disabled');
        button.innerHTML = 'Submit';
    }
}

const LoginForm = (props) => {
    function handleLogin(e){
        e.preventDefault();
        const button = e.target.querySelector('button');
        changeButtonState(button, 'loading');
        
        const formData = new FormData(e.target);
        
        fetch('/auth/login', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                
                if(data.status === 'success'){
                    Sweetalert2.fire({
                        title: 'success',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Cool 😎'
                    }).then(() => {
                        location.href = props.redirect;
                    });
                }else{
                    Sweetalert2.fire({
                        title: 'error',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Retry 😞'
                    });

                    changeButtonState(button, 'reset');
                }

            })
            .catch(error => {
                Sweetalert2.fire({
                    title: 'error',
                    text: 'An error occured. Please try again',
                    icon: 'error',
                    confirmButtonText: 'Retry 😞'
                });

                changeButtonState(button, 'reset');
            }
        );         
            
    }      
    

    return (
        <form onSubmit={handleLogin}>

            <div className="inputGroup formIntro">
                <h1 className="logoText">{props.formTitle}</h1>
            </div>

            <div className="inputGroup">
                <label htmlFor="email">Email Address</label>
                <input className="formControl" name="email" type="email" placeholder="johndoe@example.com" required={true}/>
            </div>

            <div className="inputGroup">
                <label htmlFor="password">Password</label>
                <input className="formControl" name="password" type="password" placeholder=".............." required={true} autoComplete='false' />
            </div>
            
            <div className="inputGroup formButton">
                <button id="login" className="btn btn-primary w-50 formButton" type="submit">Submit</button>
                <p>
                    <a href="/auth/reset" className="text-left">Reset Password</a> &nbsp;| &nbsp;
                    <a href="/auth/register" className="text-right">Register</a>
                </p>
            </div>

        </form>
    )
}

const RegisterForm = (props) => {
    function handleRegister(e){
        e.preventDefault();
        const button = e.target.querySelector('button');
        changeButtonState(button, 'loading');

        const formData = new FormData(e.target);

        // check password they are the same
        const password = formData.get('password');
        const confirmPassword = formData.get('confirmPassword');

        if (password !== confirmPassword) {
            Sweetalert2.fire({
                title: 'error',
                text: 'Passwords do not match',
                icon: 'error',
                confirmButtonText: 'Retry 😞'
            });

            changeButtonState(button, 'reset');
            return;
        }

        fetch('/auth/register', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {

                if(data.status == 'success'){
                    Sweetalert2.fire({
                        title: 'success',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Cool 😎'
                    }).then(() => {
                        location.href = props.redirect;
                    });
                }else{
                    Sweetalert2.fire({
                        title: 'error',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Retry 😞'
                    });

                    changeButtonState(button, 'reset');
                }

            })
            .catch(error => {
                Sweetalert2.fire({
                    title: 'error',
                    text: 'An error occured. Please try again',
                    icon: 'error',
                    confirmButtonText: 'Retry 😞'
                });

                changeButtonState(button, 'reset');
            }
        );


    }

    return (
        <form onSubmit={handleRegister}>

            <div className="inputGroup formIntro">
                <h1 className="logoText">{props.formTitle}</h1>
            </div>

            <div className="inputGroup">
                <label htmlFor="fullName">Full Name</label>
                <input className="formControl" name="fullName" type="text" placeholder="John Doe" required={true} />
            </div>

            <div className="inputGroup">
                <label htmlFor="email">Email Address</label>
                <input className="formControl" name="email" type="text" placeholder="johndoe@example.com" required={true} />
            </div>

            <div className="inputGroup">
                <label htmlFor="password">Password</label>
                <input className="formControl" name="password" type="password" placeholder=".............." required={true} autoComplete='false'  />
            </div>

            <div className="inputGroup">
                <label htmlFor="password">Confirm Password</label>
                <input className="formControl" name="confirmPassword" type="password" placeholder=".............." required={true} autoComplete='false' />
            </div>
            
            <div className="inputGroup formButton">
                <button id="register" className="btn btn-primary w-50 formButton" type="submit">Submit</button>
                <p>Have an account? <a href="/auth/login">Login</a></p>
            </div>

        </form>
    )
}

