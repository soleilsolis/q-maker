document.querySelectorAll(".submit-form").forEach(
	element => element.addEventListener('click', async function(){

		if(this.tagName == 'BUTTON'){
			this.classList.add('loading','disabled');
		}

		let formData = {};
		let headers = {};

        const formId = this.dataset.form;

		let form = document.getElementById(formId);
         
		let id = this.dataset.id;
		let send = this.dataset.send;

		if(typeof this.dataset.id !== 'undefined'){
			formData = new FormData();
			formData.append('id', id);

			headers = {
				'X-CSRF-TOKEN': document.querySelector("meta[name=csrf-token]").getAttribute("content"),
			};
		}else{
			formData = new FormData(form);
		}	
	
		const response = await fetch(send, {
			method: 'POST',
			headers: headers,
			body: formData
		})
		.then(response => response.json())
		.then(result => {
			$('#main-error').removeClass('red').removeClass('olive');

			if(typeof result.remove !== 'undefined')
				for (const [key, value] of Object.entries(result.remove)) {
					$(value).remove();
				};

			if(typeof result.changeSend !== 'undefined')
				$(result.changeSend[0]).attr('data-send',result.changeSend[1]);

			if(typeof result.disable !== 'undefined')
				for (const [key, value] of Object.entries(result.disable)) {
					$(value).attr('disabled','disabled');
				}
				
			if(typeof result.enable !== 'undefined')
				for (const [key, value] of Object.entries(result.enable)) {
					$(value).removeAttr('disabled');
				}

			if(typeof result.data !== 'undefined')
				for (const [key, value] of Object.entries(result.data)) {
					const input = document.querySelector(`[id="${key}"]`);
						
					if(input != null){
						if(input.tagName == 'INPUT'){

							const type = input.getAttribute('type');

							if(type == 'text' || type == 'number' || type == 'hidden'){
								input.value = value;
							}

							if(type == 'checkbox'){
								const mamamo = input.parentNode;
								if(value == 1){
									if(mamamo.classList.contains('checked') == false){
										mamamo.click();
									}
								}else{
									if(mamamo.classList.contains('checked') == true){
										mamamo.click();
									}
								}
							}

							if(type == 'file'){					
								const container = document.querySelector('#imageContainer');
								const template = document.getElementById("imageTemplate");

								container.innerHTML = "";

								if(value != null){
									for (const [imageId, imageValue] of Object.entries(value)) {
										//template.children[0].src = '/storage/image/';
										container.appendChild(template.content.cloneNode(true));
										container.lastElementChild.lastElementChild.src = '/storage/image/'+imageValue;
									}
								}							
							}
						}

						if(input.tagName == 'SELECT') {	
							$('.delete.icon').click();
							const ifSelect = input.parentElement;
							const selectValues = [];

							if (value != null){
								if(typeof value == 'object'){
									for(var x = 0; x < value.length; x++){
										$(`#${input.id}`).parent().find(`[data-value="${value[x]}"]`).click()
									//	document.querySelector(`[data-value=${value[x]}]`).click();
									}
								}
								else{
									$(`#${input.id}`).parent().find(`[data-value="${value}"]`).click();
								//	$(`#${input.id}:parent > [data-value="${value}"]`).click();
									//document.querySelector('#'+input+`[data-value="${value}"]`).click();
								}
							}
						}

						if(input.tagName == 'TEXTAREA')
							input.innerHTML = value;
					}

					const staticText = document.querySelector(`.${key}`);

					if(staticText != null)
						staticText.innerHTML = value;
				};

			if(typeof result.errors !== 'undefined'){
				let message = '';
				for (const [key, value] of Object.entries(result.errors)) {
					document.querySelector(`#${formId} [name=${key}]`).closest('.field').classList.add('error');
					message = value;
				};		

				result.message = message;
			}

			if(typeof result.message !== 'undefined' && result.message !== null){
				
				$('body')
				  .toast({
				    displayTime: 5000,
				    message: result.message,
					class: typeof result.color != undefined ? result.color : ''
				  })
				;

				if(this.tagName == 'BUTTON'){
					this.classList.remove('loading','disabled');
				}
			}

			if(typeof result.modal !== 'undefined')
				$(result.modal).modal('show');

			
            if(typeof result.redirect !== 'undefined')
                location.replace(result.url)

			if(result.dimmer_click === 1)
				$('.dimmer').click();

			if(typeof result.hidden !== 'undefined'){	
				for (const [key, value] of Object.entries(result.hidden)) {
					$('#'+value).parent().addClass('transition hidden');
				};	
			}

			if(typeof result.unhidden !== 'undefined'){	
				for (const [key, value] of Object.entries(result.hidden)) {
					$('#'+value).parent().removeClass('transition hidden');
				};	
			}

			if(typeof result.reload !== 'undefined')
			{	
				if(result.reload)
					location.reload();
			}
			else{
				if(this.tagName == 'BUTTON'){
					this.classList.remove('loading','disabled');
				}
			}
		});
	})
);