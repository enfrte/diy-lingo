// output file = view -> language_create.php
// uses flag-dataset.js (loaded before this file in view footer)
let langSelectField = document.getElementById('language_name');
langSelectField.addEventListener('keyup', getFlags);
let flagParent = document.getElementById('flag-container');
let countryCode = document.getElementById('country_code');

// gets and sets flag of user defined language 
function getFlags() {
    flagParent.innerHTML = ""; // remove children of flagParent node (HTML Elements) - erase old search
    let fsValue = langSelectField.value;
    //console.log(fsValue);
    let flags = [];
    // start check if 2 or more characters typed 
    if (fsValue.length > 1) {
        // search through flag-dataset object (flag icons)
        for (let index = 0; index < countryFlags.length; index++) {
            let searchNames = countryFlags[index].searchName; // searchable names array
            // each language has an array of different search names, like Finnish, Suomi. Iterate though them
            for (let index2 = 0; index2 < searchNames.length; index2++) {
                let fsValue_regex = new RegExp(fsValue, 'i'); 
                // if the typed search matches the string in the current iteration
                if (searchNames[index2].search(fsValue_regex) > -1) {
                    flags.push(countryFlags[index].fileName);
                }
            }
        }

        let uniqueFlags = Array.from(new Set(flags)); // filter duplicate search results
    
        for (let index = 0; index < uniqueFlags.length; index++) {    
            let flagImg = document.createElement("img");
            let filePath = uniqueFlags[index];
            let filename = filePath.split("/").pop().split(".")[0]; // get the filename, remove the extension            
            flagImg.dataset.value = filename; // sets a data-* attribute
            flagImg.src = filePath;
            flagImg.width = 80;
            flagImg.height = 60;
            flagImg.style.cssText += 'margin:5px;cursor:pointer;'; 
            // if the user forgets to select the flag icon and there is only one flag icon to select, use that as the language flag when the form is submitted
            if(uniqueFlags.length === 1) {
                countryCode.value = filename;
            } 
            else {
                countryCode.value = '';
            }
            flagImg.addEventListener('click', function(el) {
                countryCode.value = this.dataset.value; // add input value for selection
                // clear all image borders 
                for (let index = 0; index < flagParent.childNodes.length; index++) {
                    flagParent.childNodes[index].style.outline = 'none';
                }
                el.target.style.outline = '#32CD32 solid thick'; // show border for selected flag (border is outline here because it doesn't affect image size)
                //console.log(el);
            });
            flagParent.appendChild(flagImg);
        }
    } 
}
