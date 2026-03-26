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
