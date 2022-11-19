const regUrl = './core/api/register.php';
const loginUrl = './core/api/login.php';

document.addEventListener('DOMContentLoaded', () => {
    const $ = (elem) => document.querySelector(elem);
    const $$ = (elem) => document.querySelectorAll(elem)

    if (document.body.id == 'register') {

        const accType = new URL(window.location.href).searchParams.get('account-type') || 'buyer';

        if (accType == 'buyer') {
            $('#user-account-type').innerHTML =
                `<div class="alert alert-info">
            <p class="m-0">You are signing up as a <strong>Buyer</strong></p>
        </div>`
        } else {
            $('#user-account-type').innerHTML =
                `<div class="alert alert-info">
            <p class="m-0">You are signing up as an <strong>Agent</strong></p>
        </div>`
        }

        const form = $('#form_register')
        form.addEventListener('submit', function (e) {

            const myForm = new octaValidate('form_register')
            e.preventDefault();
            const formData = new FormData(this)
            formData.append('acc_type', accType)
            if (myForm.validate()) {

                const btn = form.querySelector('button')
                btn.setAttribute("disabled", "disabled")
                const opts = {
                    method: "POST",
                    mode: "cors",
                    body: formData
                }
                fetch(regUrl, opts)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            toastr.success(data.message)
                            setTimeout(() => {
                                window.location.href = "login"
                            }, 2000)
                        } else {
                            toastr.error(data.message)
                            btn.removeAttribute("disabled")
                        }
                    })
                    .catch(err => {
                        console.log(err)
                        btn.removeAttribute("disabled")
                        toastr.error("Sorry, we couldn't process your request")
                    })
            }
        })
    } else if (document.body.id == 'login') {

        const form = $('#form_login')
        form.addEventListener('submit', function (e) {

            e.preventDefault();
            const myForm = new octaValidate('form_login')
            const formData = new FormData(this)

            if (myForm.validate()) {

                const btn = form.querySelector('button')
                btn.setAttribute("disabled", "disabled")
                const opts = {
                    method: "POST",
                    mode: "cors",
                    body: formData
                }
                fetch(loginUrl, opts)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            localStorage.setItem('userData', JSON.stringify({
                                token: data.token,
                                accType : data.type
                            }))
                            toastr.success(data.message)
                            setTimeout(() => {
                                window.location.href = "dashboard"
                            }, 2000)
                        } else {
                            toastr.error(data.message)
                            btn.removeAttribute("disabled")
                        }
                    })
                    .catch(err => {
                        console.log(err)
                        btn.removeAttribute("disabled")
                        toastr.error("Sorry, we couldn't process your request")
                    })
            }
        })
    }
})