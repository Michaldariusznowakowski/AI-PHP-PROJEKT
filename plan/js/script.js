var roomNumbers = document.querySelectorAll('.room-number');

  
roomNumbers.forEach(function(roomNumber) {
	roomNumber.addEventListener('click', function(e) {
		e.preventDefault();


		var nextElement = this.nextElementSibling;


		if (nextElement.classList.contains('worker-info')) {
			nextElement.classList.toggle('hidden');
		}
	});
});