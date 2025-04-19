const truckId = window.truckId;
const currentUrl = window.location.href;

/**
 * Shows the loading overlay and hides the main content.
 */
function showLoading() {
    document.getElementById('loading-animation').classList.remove('hidden');
    document.getElementById('main-content').classList.add('hidden');
}

function showErrorAlert() {
    const alert = document.getElementById('error-alert');
    
    alert.classList.remove('hidden');
    document.getElementById('loading-animation').classList.add('hidden');

    setTimeout(() => {
        alert.classList.remove('-translate-y-full');
        alert.classList.add('translate-y-4');
    }, 10);
    
    setTimeout(() => {
        alert.classList.remove('translate-y-4');
        alert.classList.add('-translate-y-full');
        setTimeout(() => alert.classList.add('hidden'), 500); // wait for transition to complete
    }, 5000);
}

/**
 * Starts tracking by sending the current geolocation to the server.
 */
function startTracking() {
    showLoading();

    navigator.geolocation.getCurrentPosition(
        async (position) => {
            try {
                const { latitude, longitude } = position.coords;

                const res = await fetch('/api/location/start-tracking', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ latitude, longitude, truck_id: truckId })
                });

                const data = await res.json();

                if (data) {
                    window.location.assign(currentUrl + '/on-going');
                }
            } catch (error) {
                showErrorAlert();
            }
        },
        (error) => {
            showErrorAlert();
        }
    );
}

/**
 * Finishes tracking by sending the current geolocation to the server,
 * then shows a finish animation for 5 seconds before reloading the page.
 */
function finishTracking() {
    showLoading();

    navigator.geolocation.getCurrentPosition(
        async (position) => {
            try {
                const { latitude, longitude } = position.coords;

                const res = await fetch('/api/location/finish-tracking', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ latitude, longitude, truck_id: truckId })
                });

                const data = await res.json();

                if (data) {
                    window.location.replace(currentUrl.replace('/on-going', ''));
                }
            } catch (error) {
                showErrorAlert();
            }
        },
        (error) => {
            showErrorAlert();
        }
    );
}