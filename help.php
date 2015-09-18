<?php 
	ob_start(); 
	//instert HTML HEAD here
?>
	
<!-- html HEAD content -->
    <!-- <link rel="stylesheet" href="https://js.arcgis.com/3.13/js/dojo/dijit/themes/claro/claro.css"> -->
    <link rel="stylesheet" href="ArcGIS/javascript/dojo_1_10_4/dijit/themes/claro/claro.css">
    <!-- <link rel="stylesheet" href="http://archive.dojotoolkit.org/nightly/dojotoolkit/dojox/layout/resources/ExpandoPane.css"> -->
    <link rel="stylesheet" href="ArcGIS/javascript/dojo_1_10_4/dojox/layout/resources/ExpandoPane.css">
    <link rel="stylesheet" href="css/help.css">
    <style>
      html, body {
        height:100%;
        width:100%;
        margin:0;
        padding:0;
      }
      html, body, h1 {
        font-size: 1.2em;
        margin-top: 0px;
       
      }
      #cptop {
        height: 1.8em;
        top: 0px;
      }
      #cptop img {
        float: left;
        padding-right: 0.5em;
      }
      div#cpInnerContentArea {
        /* border-color:green; */
        padding-left: 1.4em;
      }
      .caption {
        font-size: 0.9em;
        font-style: italic;
      }
    </style>
    <script>dojoConfig = {parseOnLoad: true}</script>
    <script type="text/javascript" src="javascript/dojo/dojo.js"></script>
    <script>
      function doClick(item){
        var subContent = "";
        var subHeader = "";
        var idContent = "";
        var subContent = "";
        var serviceLink = "";
        var numChildren;
        if(typeof(item.subheader) === 'object') {
          subHeader = item.subheader;
        }
        if(typeof(item.subcontent) === 'object') {
          subContent = item.subcontent;
        }
        if(typeof(item.content) === 'object') {
          // If content is set to "#", then set the content to a list of the children.
          if (item.link == "$LIST") {
            numChildren = item.children.length;
            idContent = "<ul>";
            for (var i = 0; i < numChildren; i++) {
              idContent += "<li>" + item.children[i].name + "</li>";
            }
            idContent += "</ul>";
          } else if (item.link == "#"){
            if(item.content == "#"){
              idContent = ""; // link and content are both "#" so display nothing
            } else {
              idContent = item.content;
            }  
          } else {
            idContent = ""; // link is not "$LIST" or "#"
          }
        }
        
        // NOW SET INNER HTML
        if(typeof(item.link) === 'object'){
          // location.href = item.link;
          node = document.getElementById("cpInnerContentArea");
          if (item.type == "teaser" || item.type == "content") {
            node.innerHTML = "<h2>" + item.header + "</h2>" + "<h3>" + subHeader + "</h3>" + 
            "<p>" + idContent + "</p>" + "<p>" + subContent + "</p>";
          } else if (item.type == "subcontent") {
            if(typeof(item.layerid) === 'object') {
              if (item.service == "Parcels_and_Zoning") {
                serviceLink = "<br /><br /><a href=\"https://maps.garrettcounty.org/arcweb/rest/services/P_and_Z/Parcels_and_Zoning/MapServer/" + item.layerid + "\">Service Link</a> <span class=\"geeky\">(<span class=\"warning\">warning:</span> geeky stuff here)</span><br />";
              } else if (item.service == "FEMA") {
                serviceLink = "<br /><br /><a href=\"https://maps.garrettcounty.org/arcweb/rest/services/FEMA/FEMA/MapServer/" + item.layerid + "\">Service Link</a> <span class=\"geeky\">(<span class=\"warning\">warning:</span> geeky stuff here)</span><br />";
              } else if (item.service == "Sensitive_Areas") {
                serviceLink = "<br /><br /><a href=\"https://maps.garrettcounty.org/arcweb/rest/services/Sensitive_Areas/Sensitive_Areas/MapServer/" + item.layerid + "\">Service Link</a> <span class=\"geeky\">(<span class=\"warning\">warning:</span> geeky stuff here)</span><br />";
              } else if (item.service == "iMap_Imagery") {
                serviceLink = "<br /><br />This Map Service is created by <a href=\"http://imap.maryland.gov/\">MD iMap</a><br /><br /><a href=\"http://geodata.md.gov/imap/rest/services/Imagery/MD_SixInchImagery/MapServer/" + item.layerid + "\">Service Link</a> <span class=\"geeky\">(<span class=\"warning\">warning:</span> geeky stuff here)</span><br />";
              } else if (item.service == "Contours_and_Plan") {
                serviceLink = "<br /><br /><a href=\"https://maps.garrettcounty.org/arcweb/rest/services/Contours_and_Plan/Contours_and_Plan/MapServer/" + item.layerid + "\">Service Link</a> <span class=\"geeky\">(<span class=\"warning\">warning:</span> geeky stuff here)</span><br />";
              } else if (item.service == "TAX_MAP_GRID") {
                serviceLink = "<br /><br /><a href=\"https://maps.garrettcounty.org/arcweb/rest/services/P_and_Z/TAX_MAP_GRID/MapServer/" + item.layerid + 
                "\">Service Link</a> <span class=\"geeky\">(<span class=\"warning\">warning:</span> geeky stuff here)</span><br />";
              }
              node.innerHTML = "<h4>Layer Description: " + item.name + "</h4>" + subContent + serviceLink;
            } else {
              node.innerHTML = subContent;
            }
          }
          else {
            node.innerHTML = "This should not occur";
          }
          // testing
          // console.log("content: " + idContent);
        }
      }
    
    require([
      "dojo/_base/window", "dojo/store/Memory",
      "dojox/layout/ExpandoPane", 
      "dojo/data/ItemFileReadStore",
      // "esri/Color",
      "dojo/on",
      "dojo/dom", 
      "dojo/query", 
      "dijit/registry",
      "dojo/json",
      "dijit/tree/ObjectStoreModel",      
      "dijit/Tree",
      "dojo/parser", 
      "dijit/layout/BorderContainer", 
      "dijit/layout/ContentPane", 
      "dijit/layout/AccordionContainer", 
      "dijit/TitlePane", 
      "dijit/form/Button", 
      "dijit/form/RadioButton", 
      "dojo/domReady!"
      ], function(win, Memory, ExpandoPane, ItemFileReadStore, on, dom, query, registry, json, ObjectStoreModel, Tree, parser, BorderContainer, ContentPane, AccordionContainer, TitlePane, Button, RadioButton) {
        // onClick="function(item){location.href = item.url;}"
        // dom.on("click", doClick)  
        
        // Create test store, adding the getChildren() method required by ObjectStoreModel
        
      }); // end of require block
      
    </script>
	
<?php 
	$htmlHEAD = ob_get_contents();
	ob_end_clean();
	
	//body class
	$htmlBodyClass = 'nihilo';
	
	//build the header
	include('includes/inc.header.php'); 
	
	//you are now inside the html body:
?>

    <div data-dojo-type="dijit/layout/BorderContainer" 
         data-dojo-props="design:'headline', gutters:false" 
         style="width:100%;height:100%;margin:0;">

        <div data-dojo-type="dijit/layout/ContentPane" data-dojo-props="region:'center'" title="ContentArea" id="cpInnerContentArea">
        </div>

        <div data-dojo-type="dojox.layout.ExpandoPane" title="Table of Contents"
             data-dojo-props="region:'left', design:'footer', gutters:true, liveSplitters:true, startExpanded:true, easeIn:'expoInOut', easeOut:'expoInOut', duration:600" 
             style="width:320px;">
          <div data-dojo-type="dijit.layout.AccordionContainer" data-dojo-props="closable:false,  open:false">
            <div dojoType="dojo.data.ItemFileReadStore" data-dojo-id="continentStore"
              url="data/topics.json">      
            </div>

            <div data-dojo-type="dijit/layout/ContentPane" title="Topics" data-dojo-props="region:'center'" style="width:300px; margin-top:0; padding:0;">
            
              <div dojoType="dijit.Tree" id="thisTree" store="continentStore" query="{type:'teaser'}" data-dojo-props="onClick: doClick, openOnClick:true">
                <!-- IMPORTANT Do Not Delete or Edit the following script tag w/o doing a lot of research -->
                <!-- IMPORTANT Removing it has caused help links to main maps to ***stop working*** -->
                <!-- IMPORTANT Such as the link to "PZ Map", "FEMA Map", "Measurement Map", "Printable Map" etc. -->
                <!-- IMPORTANT And make no mistake, the code in the header section is also ***required*** -->
                <script type="dojo/method" data-dojo-event="onOpen" data-dojo-args="item">
                  var idContent;
                  var subContent = "";
                  var subHeader = "";
                  var idContent = "";
                  var subContent = "";
                  var serviceLink = "";
                  var numChildren;
                  if(typeof(item.subheader) === 'object') {
                    subHeader = item.subheader;
                  }
                  if(typeof(item.subcontent) === 'object') {
                    subContent = item.subcontent;
                  }                  
                  if(typeof(item.content) === 'object') {
                    // If content is set to "#", then set the content to a list of the children.
                    if (item.link == "$LIST") {
                      numChildren = item.children.length;
                      idContent = "<ul>";
                      for (var i = 0; i < numChildren; i++) {
                        idContent += "<li>" + item.children[i].name + "</li>";
                      }
                      idContent += "</ul>";
                    } else if (item.link == "#"){
                      if(item.content == "#"){
                        idContent = ""; // link and content are both "#" so display nothing
                      } else {
                        idContent = item.content;
                      }  
                    } else {
                      idContent = ""; // link is not "$LIST" or "#"
                    }
                  }
                  // NOW SET INNER HTML
                  if(typeof(item.link) === 'object'){
                    // location.href = item.link;
                    node = document.getElementById("cpInnerContentArea");
                    if (item.type == "teaser" || item.type == "content") {
                      node.innerHTML = "<h2>" + item.header + "</h2>" + "<h3>" + subHeader + "</h3>" + 
                      "<p>" + idContent + "</p>" + "<p>" + subContent + "</p>";
                    } else if (item.type == "subcontent") {
                      if(typeof(item.layerid) === 'object') {
                        if (item.service == "Parcels_and_Zoning") {
                          serviceLink = "<br /><br /><a href=\"https://maps.garrettcounty.org/arcweb/rest/services/P_and_Z/Parcels_and_Zoning/MapServer/" + item.layerid + "\">Service Link</a> <span class=\"geeky\">(<span class=\"warning\">warning:</span> geeky stuff here)</span><br />";
                        } else if (item.service == "FEMA") {
                          serviceLink = "<br /><br /><a href=\"https://maps.garrettcounty.org/arcweb/rest/services/FEMA/FEMA/MapServer/" + item.layerid + "\">Service Link</a> <span class=\"geeky\">(<span class=\"warning\">warning:</span> geeky stuff here)</span><br />";
                        } else if (item.service == "Sensitive_Areas") {
                          serviceLink = "<br /><br /><a href=\"https://maps.garrettcounty.org/arcweb/rest/services/Sensitive_Areas/Sensitive_Areas/MapServer/" + item.layerid + "\">Service Link</a> <span class=\"geeky\">(<span class=\"warning\">warning:</span> geeky stuff here)</span><br />";
                        }
                        node.innerHTML = "<h4>Layer Description: " + item.name + "</h4>" + subContent + serviceLink;
                      } else {
                        node.innerHTML = subContent;
                      }
                    }
                    else {
                      node.innerHTML = "This should not occur";
                    }
                  }

            	  </script>

              </div>
              </div>
            </div><!-- Topics -->
          </div><!-- Accordion Container -->
        </div><!-- Expando Pane -->
      <!--</div><!-- Border Container - Content Pane Outer Content Area -->
    </div><!-- Border Container -->

	
<?php include('includes/inc.footer.php'); ?>