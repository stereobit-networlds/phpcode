<script type="text/javascript" src="js/jquery.cookiebar.js"></script>
<script type="text/javascript" src="js/zebra/zebra_dialog.js"></script>	
	
<script type="text/javascript">
	$(document).ready(function(){
		$.cookieBar({
			message: '<phpdac>cmsrt.slocale use _cookiesmsg</phpdac>',
			acceptText: '.',
			element: 'body',
			autoEnable: false,
			acceptOnScroll: 100,
			acceptFunction: function(cookieValue){if(cookieValue!='enabled' && cookieValue!='accepted') start();}
		});
	});
	
function setInfo(i) { document.getElementById('info').value = i; };
function setMode(i) { document.getElementById('mode').value = i; };
function remPass() { document.getElementById('fa').value == 'shreg' ?
                     document.getElementById('fa').value = 'shremember' :
					 document.getElementById('fa').value = 'shreg'; 
					 document.getElementById('sb').innerHTML == 'Submit' ?
					 document.getElementById('sb').innerHTML = 'Reset' : 
					 document.getElementById('sb').innerHTML = 'Submit';}
function start() {<phpdac>jsdialog.startDialog</phpdac>}				 
function openmsg() {
	var viewportwidth = document.documentElement.clientWidth; var viewportheight = document.documentElement.clientHeight;
	window.resizeBy(-450,0); window.moveTo(0,0); window.open("https://el-gr.messenger.com/login?next=https%3A%2F%2Fwww.messenger.com%2Ft%2Fstereobit.gr%2F","messenger","height=680,width=450,left="+(viewportwidth-450)+",top=0,scrollbar=0");}
</script>
<!-- e-Enterprise, stereobit.networlds (phpdac5) -->