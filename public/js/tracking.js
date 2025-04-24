const truckId = window.truckId;
const currentUrl = window.location.href;
let currentPosition = null;

/**
 * Shows the location fetching alert
 */
function showLocationAlert() {
    const alert = document.getElementById('getting-location-alert');
    alert.classList.remove('-translate-y-full', 'hidden');
    alert.classList.add('translate-y-4');
}

/**
 * Hides the location fetching alert
 */
function hideLocationAlert() {
    const alert = document.getElementById('getting-location-alert');
    alert.classList.remove('translate-y-4');
    alert.classList.add('-translate-y-full');
    setTimeout(() => alert.classList.add('hidden'), 500);
}

/**
 * Shows the error alert for 5 seconds
 */
function showErrorAlert() {
    const alert = document.getElementById('error-alert');

    hideLoading();

    alert.classList.remove('-translate-y-full', 'hidden');
    alert.classList.add('translate-y-4');

    setTimeout(() => {
        alert.classList.remove('translate-y-4');
        alert.classList.add('-translate-y-full');
        setTimeout(() => alert.classList.add('hidden'), 500);
    }, 5000);
}

/**
 * Shows the loading overlay and hides the main content
 */
function showLoading() {
    document.getElementById('loading-overlay').classList.remove('hidden');
    document.getElementById('main-content').classList.add('hidden');
}

/**
 * Hides the loading overlay and shows the main content
 */
function hideLoading() {
    document.getElementById('loading-overlay').classList.add('hidden');
    document.getElementById('main-content').classList.remove('hidden');
}

/**
 * Disables tracking buttons
 */
function disableButtons() {
    const startButton = document.querySelector('[onclick="startTracking()"]');
    const finishButton = document.querySelector('[onclick="finishTracking()"]');

    if (startButton) startButton.disabled = true;
    if (finishButton) finishButton.disabled = true;
}

/**
 * Enables tracking buttons
 */
function enableButtons() {
    const startButton = document.querySelector('[onclick="startTracking()"]');
    const finishButton = document.querySelector('[onclick="finishTracking()"]');

    if (startButton) startButton.disabled = false;
    if (finishButton) finishButton.disabled = false;
}

/**
 * Gets the current location and stores it in currentPosition
 * @returns {Promise} Resolves when location is fetched, rejects if error
 */
function getCurrentLocation() {
    return new Promise((resolve, reject) => {
        showLocationAlert();
        disableButtons();

        navigator.geolocation.getCurrentPosition(
            (position) => {
                currentPosition = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude
                };
                console.log('Successfully fetched location:', currentPosition);
                hideLocationAlert();
                enableButtons();
                resolve(currentPosition);
            },
            (error) => {
                console.error('Failed to get location:', error);
                hideLocationAlert();
                enableButtons();
                showErrorAlert();
                reject(error);
            },
            {
                enableHighAccuracy: true,
                timeout: 30000,
                maximumAge: 0
            }
        );
    });
}

/**
 * Starts tracking by sending the current location to the server
 */
async function startTracking() {
    try {
        showLoading();
        const res = await fetch('/api/location/start-tracking', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ ...currentPosition, truck_id: truckId })
        });

        const data = await res.json();
        if (data) {
            window.location.href = currentUrl + '/on-going';
        }
    } catch (error) {
        showErrorAlert();
    }
}

/**
 * Finishes tracking by sending the current location to the server
 */
async function finishTracking() {
    try {
        showLoading();
        const res = await fetch('/api/location/finish-tracking', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ ...currentPosition, truck_id: truckId })
        });

        const data = await res.json();
        if (data) {
            // Hide the loading overlay and show the finish animation
            document.getElementById('loading-overlay').classList.add('hidden');
            document.getElementById('finish-shipping-animation').classList.remove('hidden');

            // After 5 seconds, redirect
            setTimeout(() => {
                window.location.href = currentUrl.replace('/on-going', '');
            }, 5000);
        }
    } catch (error) {
        showErrorAlert();
    }
}

// Start fetching location when page loads
document.addEventListener('DOMContentLoaded', () => {
    getCurrentLocation().catch(() => { });
});