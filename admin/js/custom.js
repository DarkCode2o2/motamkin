document.addEventListener('DOMContentLoaded', function() {

    const selectMenu = document.getElementById('categorySelect');
    bundleOption = document.getElementById('second_bundle_number');

    if(selectMenu) {
        if(selectMenu.value == 5) {

            bundleOption.style.display = 'inline-block';
            }else {
                
            bundleOption.style.display = 'none';
        }
        selectMenu.addEventListener('change', function() {
            selectedOpetionNumber =  parseInt(this.value);
        
            if(selectedOpetionNumber == 5 || selectMenu.value == 5) {

                bundleOption.style.display = 'inline-block';
            }else {
                
                bundleOption.style.display = 'none';
            }
        })
    } else {
        console.error("لم يتم العثور على عنصر");
    }
});



function rotateArrow(element) {
    element.querySelector('.users-arrow').classList.toggle('rotateArrow');
}



 // ========================================================
  // SHOW SECOND NUMBER INPUT WHEN BUNDLE CATEGORY SELECTED 
  // ========================================================

  let selectedCategory = document.getElementById('categorySelect');
  let fSecondNumber = document.getElementById('second_bundle_number');

  if(selectedCategory) {
    let secondNumberInput = fSecondNumber.querySelector('#number_two');

    if(selectedCategory.value == 5) {
      fSecondNumber.classList.remove('d-none')
      secondNumberInput.setAttribute('required', 'required');
    }else {
      fSecondNumber.classList.add('d-none')
      secondNumberInput.value = '';
      secondNumberInput.removeAttribute('required')

    }
    selectedCategory.addEventListener('change', function() {
        if(selectedCategory.value == 5) {
          fSecondNumber.classList.remove('d-none')
          secondNumberInput.setAttribute('required', 'required')

        }else {
          fSecondNumber.classList.add('d-none')
          secondNumberInput.value = '';
          secondNumberInput.removeAttribute('required')

        }

        rangeNumber(selectedCategory.value);
    })
    rangeNumber(selectedCategory.value);

}


function rangeNumber(catNumber) {    
    const price = document.getElementById('price');
    if(price) {
        if(catNumber == 1) {
            price.value = 499; 
        }else if(catNumber == 2) {
            price.value = 1499; 
        }else if(catNumber == 3) {
            price.value = 4999; 
        }else if(catNumber == 4) {
            price.value = 5000; 
        }else {
            price.value = 0; 
        }
    }
}

