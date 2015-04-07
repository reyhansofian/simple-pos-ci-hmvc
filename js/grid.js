var status = 1;

function del_confirm(name)
{
	return confirm('Apakah Anda yakin akan menghapus data "' + name + '"?');
}

function chosen(checkbox, alt)
{
	var chosen_color = 'light';

	if (alt == 'even') {
		chosen_color = 'dark';
	}

	if (checkbox.checked == true) {
		checkbox.parentNode.parentNode.className = chosen_color;
	}
	else if (checkbox.checked == false) {
		checkbox.parentNode.parentNode.className = alt;
	}
}

function select_all(checkbox, checkbox_list)
{
	var num = checkbox_list.length;

	if (checkbox.checked == true) {
		for (i = 0; i < num; i++) {
			checkbox_list[i].checked = true;
			
			if (i % 2 == 0) {
				checkbox_list[i].parentNode.parentNode.className = 'light';
			}
			else {
				checkbox_list[i].parentNode.parentNode.className = 'dark';
			}
		}
	}
	else if (checkbox.checked == false) {
		for (i = 0; i < num; i++) {
			checkbox_list[i].checked = false;
			
			if (i % 2 == 0) {
				checkbox_list[i].parentNode.parentNode.className = '';
			}
			else {
				checkbox_list[i].parentNode.parentNode.className = 'even';
			}
		}
	}
}

function multi_del_confirm(sender)
{
	var num 	= sender.elements.length;
	var checked = false;
	
	for (i = 1; i < num; i++) {
		if (sender.elements[i].checked) {
			checked = true;
			break;
		}
	}
	
	if (checked == false) return false;
	return confirm('Apakah Anda yakin akan menghapus data tersebut?');
}

function multi_del_submit()
{
	var form	= document.getElementById('grid');
	var go		= multi_del_confirm(form);
	
	if (go) form.submit();
	status = 0;
}

function check(sender)
{
	var num 	= sender.elements.length;
	var checked = false;
	
	for (i = 1; i < num; i++) {
		if (sender.elements[i].checked) {
			checked = true;
			break;
		}
	}
	
	if (checked == false) return false;
}