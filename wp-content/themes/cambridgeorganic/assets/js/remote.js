document.addEventListener("DOMContentLoaded", ()=>{
    document.addEventListener('submit', async (e) => {
        const form = e.target;

        if (!form.matches('.ajax-submit')) {
            return;
        }

        e.preventDefault();

        const errorEl = document.getElementById('default-error-message');

        // Clear previous error
        if (errorEl) {
            errorEl.textContent = '';
            errorEl.style.display = 'none';
        }

        form.classList.add('loading');

        try {
            const formData = new FormData(form);

            const response = await fetch(form.action, {
                method: form.method || 'POST',
                body: formData,
            });

            const data = await response.json();

            form.classList.remove('loading');
            if (
                data &&
                Number(data.success) === 0 &&
                typeof data.message === 'string'
            ) {
                if (errorEl) {
                    errorEl.textContent = data.message;
                    errorEl.style.display = '';
                }
                return;
            }

            // Success callback/event
            if(data.success && data.redirect) {
                window.location = data.redirect;
            }

        } catch (error) {
            if (errorEl) {
                errorEl.textContent = 'An unexpected error occurred. Please try again.';
                errorEl.style.display = '';
            }
            form.classList.remove('loading');

            console.error(error);
        }
    });
});

window.get_remote_request = async function (endpoint='', attrs = {}) {
    // const required = ['action'];
    //
    // // Check required attributes
    // for (const key of required) {
    //     if (!attrs[key]) {
    //         throw new Error(`Missing required attribute: ${key}`);
    //     }
    // }

    endpoint = site_url+'remote-request/'+endpoint;

    try {
        let $fetch_attrs = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(attrs)
        };

        const response = await fetch(endpoint, $fetch_attrs);

        if (!response.ok) {
            throw new Error(`Request failed with status ${response.status}`);
        }

        return await response.json();
    } catch (error) {
        console.error('Remote request error:', error);
        throw error;
    }
}

