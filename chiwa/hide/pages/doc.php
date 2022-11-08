<style>
#doc{
	font-family: 'roobert', sans-serif;
	-webkit-text-size-adjust: 100%;
}
h2 {
	margin-top: 16px;
	font-size: 1.8em;
	font-weight: 500;
	line-height: 1.2em;
	padding-bottom: 5px;
	border-bottom: 1px solid #d9d9de;
	margin-top: 0px;
}
h3 {
	font-size: 1.4em;
	line-height: 1.2em;
	font-weight: 400;
}
p {
	font-size: 1.1rem;
	line-height: 1.6em;
	margin-top: 0;
}
code {
	background: #4d00ff1a;
	padding: 1px 3px;
	word-wrap: break-word;	
	border-radius: 3px;
	border: 1px solid #ac8bf9;
	-webkit-text-size-adjust: 100%;
	font-size: 0.9rem;
}
table{
	border: 1px solid #dbd7df;
	margin: 0 0 20px 0;
	border-collapse: collapse;
	font-size: 1.1rem;
	line-height: 1.2em;
}
table th, table td {
	border: 1px solid #dbd7df;
	padding: 5px;
	text-align: left;
	min-width: 100px;
}
table th {
	font-weight: 700;
}
table tr:nth-child(odd) {
	background: var(--bkc3);
}
table td {
	vertical-align: top;
}
</style>
<div id='doc'><div>
	<h2>Send Data</h2>
	<p>上傳 Arduino 之偵測數值。</p>
	<h3>URL</h3>
	<p><code>POST https://nutcproj.sgod.me/api/send</code></p>
	<h3>Required Query Parameter</h3>
	<p>None</p>
	<h3>Required Body Parameters</h3>
	<table>
		<tr><th>Parameter</th><th>Type</th><th>Description</th></tr>
		<tr><td><code>token</code></td><td>string</td><td>請求認證令牌</td></tr>
	</table>
	<h3>Optional Body Parameters</h3>
	<table>
		<tr><th>Parameter</th><th>Type</th><th>Description</th></tr>
		<tr><td><code>temperature</code></td><td>float</td><td>溫度數值</td></tr>
		<tr><td><code>humidity</code></td><td>float</td><td>濕度數值</td></tr>
		<tr><td><code>weight</code></td><td>float</td><td>重量數值</td></tr>
	</table>
	<h3>Response Fields</h3>
	<table>
		<tr><th>Field</th><th>Type</th><th>Description</th></tr>
		<tr><td><code>s</code></td><td>integer</td><td>0: failed. 1: success.</td></tr>
		<tr><td><code>e</code></td><td>string</td><td>Failed message.</td></tr>
	</table>
</div></div>