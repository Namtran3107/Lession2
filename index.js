function hideCategory() {
	var page = new URLSearchParams(window.location.search);
	let pages = page.get('page');
	if(pages===null){
		pages = 1;
	}

	const category = document.querySelectorAll(".category-list-body");
	var start = (pages*10)-10;
	var endstart = pages*10;
	if (endstart > category.length) {
		endstart = category.length;
	}
	for(let i = start; i < endstart; i++){
		category[i].style.display = "block";
	}
}

hideCategory()

function totalSearch(){
	const total = document.getElementsByClassName('category-list-body').length;
	document.querySelector('.return-search').innerHTML = total;
	
}

totalSearch();