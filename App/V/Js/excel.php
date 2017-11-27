<style>li {  list-style: none; }

li:before {
    position: relative;
    content: "✓";
    width: 0;
    display: inline-block;
    left: -2ch;
}

input {
    border: none;
    width: 80px;
    font-size: 14px;
    padding: 2px;
}

input:hover { background-color: #eee; }
input:focus { background-color: #ccf; }

input:not(:focus) {
    text-align: right;
}

table { border-collapse: collapse; }

td {
    border: 1px solid #999;
    padding: 0;
}

tr:first-child td, td:first-child {
    background-color: #ccc;
    padding: 1px 3px;
    font-weight: bold;
    text-align: center;
}

footer { font-size: 80%; }
</style>

<p>25js行实现的excel表格</p>
<p>This is an updated version of <a href="http://jsfiddle.net/ondras/hYfN3/">http://jsfiddle.net/ondras/hYfN3/</a>. Some people argued that the original approach was too hacky and incompatible with strict/ES2015, so here we go again <strong>without <code>with</code>:</strong></p>

<ul>
    <li>25 lines of vanilla ES2015: arrow functions, destructuring, template literals, spread</li>
    <li>No libraries or frameworks</li>
    <li>Excel-like syntax (formulas start with "=")</li>
    <li>Support for arbitrary expressions (=A1+B2*C3)</li>
    <li>Circular reference prevention</li>
    <li>Automatic localStorage persistence</li>
</ul>

<table></table>
    
<footer><p>&copy; 2017 <a href="http://ondras.zarovi.cz/">Ondřej Žára</a></p></footer>



<script>
for (let i=0; i<6; i++) { /* build the table */
	let row = document.querySelector("table").insertRow()
	for (let j=0; j<6; j++) {
		let letter = String.fromCharCode("A".charCodeAt(0)+j-1)
		row.insertCell().innerHTML = i&&j ? `<input id=${letter}${i} />` : i||letter
	}
}
let keys = Array.from(document.querySelectorAll("input")).map(i => i.id) // spread not in Edge

function valueOf(key) { /* recursively compute a value */
	let val = localStorage[key] || ""
	if (val[0] == "=") {
		let f = new Function(...keys, `return eval("${val.substr(1)}")`)
		return f(...keys.map(key => ({valueOf: _ => valueOf(key)}))).valueOf()
	} else {
		return isNaN(parseFloat(val)) ? val : parseFloat(val)
	}
}

(window.update = _ => keys.forEach(key => { /* update all fields */
	try { document.getElementById(key).value = valueOf(key) } catch (e) {}
}))()

window.addEventListener("focus", e => e.target.value = localStorage[e.target.id] || "", true)
window.addEventListener("blur", e => (localStorage[e.target.id] = e.target.value, update()), true)

</script>