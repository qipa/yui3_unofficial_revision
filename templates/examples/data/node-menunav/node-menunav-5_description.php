<h3>Creating the Shadow HTML</h3>
<p>
One way to add shadows to submenus is to append decorator elements the node representing a 
submenu's bounding box.  As the name implies, decorator elements add no semantic value to the 
markup, but enable additional styles to be applied.  When adding any decorator elements to create 
effects like shadows or rounded corners, always add those elements via JavaScript, since it is only 
when JavaScript is enabled that a menu's markup is transformed in a drop-down menu system via the 
MenuNav Node Plugin.
</p>

<p>
Each shadow will be represented in HTML as a single <code>&#60;div&#62;</code> element with a class
of <code>yui-menu-shadow</code> applied, and can easily be created by passing a string of HTML
to Node's <a href="../../api/Node.html#method_create"><code>create</code></a> method.  Use the 
<a href="../../api/Node.html#method_queryAll"><code>queryAll</code></a> method to 
retrieve Node instances for each submenu, and the 
<a href="../../api/Node.html#method_appendChild"><code>appendChild</code></a> method to add the 
shadow to each submenu.
</p>

<textarea name="code" class="JScript" cols="60" rows="1">
<script type="text/javascript">
//	Call the "use" method, passing in "node-menunav".  This will load the 
//	script and CSS for the MenuNav Node Plugin and all of the required 
//	dependencies.

YUI().use("node-menunav", function(Y) {

	//	Use the "contentready" event to initialize the menu when the subtree of 
	//	element representing the root menu (<div id="productsandservices">) is ready to 
	//	be scripted.

	Y.on("contentready", function () {

		//	The scope of the callback will be a Node instance representing 
		//	the root menu (<div id="productsandservices">).  Therefore, since "this"
		//	represents a Node instance, use the "queryAll" method to retrieve the 
		//	Node instances representing each submenu.

		this.queryAll(".yui-menu").each(function (node) {
		
			// Append a shadow element to the bounding box of each submenu

			node.appendChild(Y.Node.create('<div class="yui-menu-shadow"></div>'));
		
		});

		//	Call the "plug" method of the Node instance, passing in a reference to the
		//	MenuNav Node Plugin.
	
		this.plug(Y.plugin.NodeMenuNav);

	}, "#productsandservices");

});
</script>
</textarea>

<h3>Styling the Shadow HTML</h3>
<p>
With the shadow element appended to each submenu, the next step is to define the style for the 
shadow.  The shadows in this example will be 12% alpha transparent black, and offset from the left, 
bottom, and right edges of each submenu's content box by 3px.  To create this effect, start by 
setting the <code>position</code> property to <code>absolute</code> and the <code>z-index</code> 
property to <code>-1</code>.  This will position each submenu's shadow behind its content box.  For 
the 12% alpha transparent black color, set the <code>background-color</code> to <code>#000</code> 
and <code>opacity</code> property to <code>.12</code>. 
</p>

<p>
Next, set the both the <code>width</code> and <code>height</code> properties to <code>100%</code> 
so that the dimensions of the <code>shadow</code> match that of each submenu's bounding box.  
(<em>Note:</em>  Setting the <code>height</code> property to <code>100%</code> won't work in IE 6 
Strict Mode unless the element's parent element has a height defined.  For this reason the the 
MenuNav Node Plugin automatically sets the <code>width</code> and <code>height</code> properties of 
each submenu's bounding box to the values of its <code>offsetWidth</code> and 
<code>offsetHeight</code> properties before it is made visible.)
</p>

<p>
To create the three-sided effect for the shadow, set the <code>padding</code> property to 
<code>1px 3px 0 3px</code>.  As the CSS Box Model specifies that the value for padding is used to 
calculate the total width of of an element, the addition of the padding to the shadow makes the 
rendered width of the shadow 6px wider (100% + 6px) and 1px taller (100% + 1px) than that of each 
submenu's bounding box.  Finally, setting the <code>top</code> property to <code>2px</code> and
the <code>left</code> property to <code>-3px</code> will position the shadow so that its offset 
from the left, bottom, and right edge of each submenu's content box by 3px.
</p>

<textarea name="code" class="CSS" cols="60" rows="1">
.yui-menu-shadow {

	position: absolute;
	z-index: -1;		
	top: 2px;
	left: -3px;
	
	background-color: #000;
	opacity: .12;
	filter: alpha(opacity=12);	/*	For IE since it doesn't implement the CSS3 
									"opacity" property. */

	padding: 1px 3px 0 3px;
	width: 100%;
	height: 100%;

}
</textarea>

<p>
Lastly, it is necessary to modify the position and dimensions of the <code>&#60;iframe&#62;</code> 
shim, otherwise <code>&#60;select&#62;</code> elements will poke through each submenu's shadow in 
IE 6.  Start by setting the <code>z-index</code> property to <code>-2</code> so that the 
<code>&#60;iframe&#62;</code> shim is behind the shadow element.  Next, set the <code>padding</code>
property to <code>3px 3px 0 3px</code>.  The core CSS file for MenuNav already sets the 
<code>height</code> and <code>width</code> properties to <code>100%</code>, so the addition of the 
padding will result in the calculated width and height of the <code>&#60;iframe&#62;</code> shim 
being 100% + 6px and 100% + 3px respectively &#151; enough to shim the shadow.  Lastly, setting the 
<code>left</code> property to <code>-1</code> syncs the left edge of the 
<code>&#60;iframe&#62;</code> with that of the shadow.
</p>

<textarea name="code" class="CSS" cols="60" rows="1">
#productsandservices .yui-menu .yui-shim {

	z-index: -2;	/* Place the iframe shim behind the shadow element */

	/*
		Adjust the dimensions of the <iframe> shim to match the shadow, 
		otherwise <select> elements will poke through the shadow.
	*/

	left: -3px;
	padding: 3px 3px 0 3px;

}
</textarea>