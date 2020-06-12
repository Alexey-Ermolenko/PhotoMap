function Open_modal(www) {

	console.log("www = " + www.src);
	
	src_big = $(www).attr("src_big");
	src_xxbig = $(www).attr("src_xxbig");
	
	user = $(www).attr("user");
	console.log("user = " + user);
	console.log("src_big = " + src_big);
	$("#myModalonJS").modal('show');
	
	//#modal_image
	$("#modal_image").attr("src", src_big);
	$("#origin_img").attr("href", src_xxbig);
	$("#origin_img").html(src_xxbig); 
	
	$("#username").attr("href", user);
	$("#username").html(user); 
}

				