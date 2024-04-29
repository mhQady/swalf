// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyDq9cKF88f5V5gUymdEeHoB2aW18Yp-P9s",
    authDomain: "swalfapp-420418.firebaseapp.com",
    projectId: "swalfapp-420418",
    storageBucket: "swalfapp-420418.appspot.com",
    messagingSenderId: "784489128451",
    appId: "1:784489128451:web:ee8454ce78e6f3eb30e436",
    measurementId: "G-YSMXL4QT1Z"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);

console.log('fireeeeee');
