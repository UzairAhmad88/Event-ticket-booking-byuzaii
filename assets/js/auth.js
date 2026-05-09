// REGISTER VALIDATION

const registerForm =
    document.querySelector('form');

if(registerForm){

    registerForm.addEventListener('submit', (e) => {

        const password =
            document.querySelector(
                'input[name="password"]'
            );

        if(password && password.value.length < 6){

            e.preventDefault();

            alert(
                "Password must be at least 6 characters"
            );

        }

    });

}