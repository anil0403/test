const card = document.querySelector(".card");
const searchInput = document.querySelector(".search-bar input");
const tempBox = document.querySelector(".temp-box");
const weatherIcon = document.querySelector(".weather-icon img");
const currentTemp = document.querySelector(".current-temp");
const descriptionDisplay = document.querySelector(".description");
const locationResponseIcon = document.querySelector(".location-response-icon");
const locationResponseName = document.querySelector(".location-response-name");
const weatherDetails = document.querySelector(".weather-details");

// ERROR BOX
const errorBox = document.querySelector(".error-box");
const errorIcon = document.querySelector(".error-icon img");
const errorMessage = document.querySelector(".error-message");

searchButton.addEventListener("click", search);
searchInput.addEventListener("keypress", (event) => {
    if (event.key === "Enter") {
        search();
    }
})

function search () {

    // RESET
    tempBox.style.display = "none";
    errorBox.style.display = "none";

    // weatherIcon.src = ""
    // currentTemp.style.display = "none"
    // descriptionDisplay.innerText = "";
    // locationResponseIcon.style.display = "none"
    // locationResponseName.style.display = "none"
    // weatherDetails.style.display = "none"

    // weatherIcon.classList.remove("slide-in");
    // descriptionDisplay.classList.remove("grow-in");

    // GET CITY NAME FROM INPUT
    const cityName = document.querySelector(".search-bar input").value;
    
    if (cityName === '') { // If city is blank hide temp-box
        card.style.height = "128px";
        return;
    }
    
        


    const apiKey = "50a7aa80fa492fa92e874d23ad061374";
    const apiCall = `https://api.openweathermap.org/data/2.5/weather?q=${cityName}&units=metric&appid=${apiKey}`

    fetch(apiCall)
    .then(response => response.json())
    // SUCCESS
    .then(
        result => {


            // IF 404 ERROR
            if (result.cod == '404') {
                card.style.height = "385px"
                errorBox.style.display = "flex";
                errorIcon.classList.add("grow-in");
                errorMessage.classList.add("grow-in");
                return;
            }

            // IF SUCCESS
            tempBox.style.display = "flex";
            card.style.height = "720px"

            weatherIcon.classList.add("slide-in");
            currentTemp.classList.add("grow-in");
            descriptionDisplay.classList.add("grow-in");
            locationResponseIcon.classList.add("grow-in");
            locationResponseName.classList.add("grow-in");
            weatherDetails.classList.add("grow-in");

            // GET WEATHER INFO
            console.log(result);
            const city = result.name;
            const country = result.sys.country;
            const {description, id} = result.weather[0];
            const {temp, humidity, } = result.main;
            const windSpeed = result.wind.speed;

            // PASS VALUES TO HTML ELEMENT
            document.querySelector(".current-temp .num").innerText = Math.round(temp);
            document.querySelector(".description").innerText = description;
            document.querySelector(".location-response-name").innerText = `${city}, ${country}`;
            document.querySelector(".humidity").innerText = humidity + "%";
            document.querySelector(".wind-speed").innerText = windSpeed + " Km/h";

            if (id === 800) {
                weatherIcon.src = "";
            }
            else if ((id >= 300 && id <= 321) || (id >= 500 && id <= 531)) {
                weatherIcon.src = "";
            }
            else if (id >= 600 && id <= 622) {
                weatherIcon.src = "";
            }
            else if (id >= 701 && id <= 781) {
                weatherIcon.src = "";
            }
            else if (id >= 801 && id <= 804) {
                weatherIcon.src = "";
            }
             
             
            
        }
    )

}
function time(){
    let d= new Date();
        month=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
        for(let i=0;i<12;i++){
            if(d.getMonth()==i){
                date=month[i]+" "+d.getDate()+", "+d.getFullYear();
                document.getElementById("time").innerHTML=date;
            }
        }
       
}
function fdata(){
    temp=document.getElementById("data").innerText;
    console.log(temp);
    document.getElementById("showweather").innerText=temp;

};
fdata();
time();
search();