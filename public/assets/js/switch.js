/**
 *  Light Switch @version v0.1.2
 *  @author han109k
 */

(function () {
    let lightSwitch = document.getElementById("lightSwitch");
    if (lightSwitch) {
        darkMode();
        lightSwitch.addEventListener("change", () => {
            lightMode();
        });

        /**
         * @function darkmode
         * @summary: firstly, checks if browser local storage has 'lightSwitch' key
         * if key has 'dark' value then changes the theme to 'dark mode'
         * Basically, replaces/toggles every CSS class that has '-light' class with '-dark'
         */
        function darkMode() {
            let isSelected =
                localStorage.getItem("lightSwitch") !== null &&
                localStorage.getItem("lightSwitch") === "dark";

            if (isSelected) {
                lightSwitch.checked = true;
                document.querySelectorAll(".bg-light").forEach((element) => {
                    element.className = element.className.replace(/-light/g, "-dark");
                });
                document.querySelectorAll(".table-light").forEach((element) => {
                    element.className = element.className.replace(/-light/g, '-dark')
                })

                document.body.classList.add("bg-dark");
                document.body.style.backgroundColor = "#2d3238"

                if (document.body.classList.contains("text-dark")) {
                    document.body.classList.replace("text-dark", "text-white");
                } else {
                    document.body.classList.add("text-white");
                }

                document.querySelectorAll(".text-dark").forEach((element) => {
                    element.className = element.className.replace("text-dark", "text-white")
                })
                document.querySelector("#footer-credit").style.backgroundColor = "#181b1f"
                // set light switch input to true
            } else if (localStorage.getItem('lightSwitch') === "white") {
                lightMode()
            }
        }

        /**
         * @function lightmode
         * @summary: check whether the switch is on (checked) or not.
         * If the switch is on then set 'lightSwitch' local storage key and call @function darkmode
         * If the switch is off then it is light mode so, switch the theme and
         *  remove 'lightSwitch' key from local storage
         */
        function lightMode() {
            if (lightSwitch.checked) {
                localStorage.setItem("lightSwitch", "dark");
                darkMode();
            } else {
                document.querySelectorAll(".bg-dark").forEach((element) => {
                    element.className = element.className.replace(/-dark/g, "-light");
                });
                document.querySelectorAll(".text-white").forEach((element) => {
                    element.className = element.className.replace("text-white", "text-dark")
                })
                document.querySelectorAll(".table-dark").forEach((element) => {
                    element.className = element.className.replace(/-dark/g, '-light')
                })
                document.body.style.backgroundColor = "#ffff"
                document.querySelector("#footer-credit").style.backgroundColor = "#d5d5d5"
                document.body.classList.replace("text-white", "text-dark");
                // localStorage.removeItem("lightSwitch");
                localStorage.setItem('lightSwitch', 'white')
            }
        }
    }
})();
