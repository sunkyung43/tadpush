$(document).ready(function(){
	$.ui.dynatree.nodedatadefaults["icon"] = false;
//	$.ui.dynatree.nodedatadefaults["expand"] = true;
	
	$.ui.dynatree.prototype.options["debugLevel"] = 0;
	$.ui.dynatree.prototype.options["checkbox"] = true;
	$.ui.dynatree.prototype.options["selectMode"] = 3;
//	$.ui.dynatree.prototype.options["minExpandLevel"] = 3;
	
	$.ui.dynatree.prototype.options["onKeydown"] = function(node, event) {
		if (event.which == 32) {
			node.toggleSelect();
			return false;
		}
	};
	
	$.ui.dynatree.prototype.options["onDblClick"] = function(node, event) {
		node.toggleSelect();
	};
});

function addDynatree(treeID, json, selectedID) {
	if($("#" + selectedID).length == 0) {
		$('<input>').attr({
		    type: 'hidden',
		    id: selectedID,
		    name: selectedID
		}).insertAfter("#" + treeID);
	}
	
	$("#" + treeID).dynatree({
		children : json,
		onSelect : function(select, node) {
			 // Display list of selected nodes
	        var selNodes = node.tree.getSelectedNodes();
	        // convert to title/key array
			var selKeys = $.map(selNodes, function(node) {
				if(node.data.key != '' && node.data.key.indexOf('_') != 0) {
					return node.data.key;
				}
			});
			$("#" + selectedID).val(selKeys.join(","));
		},
		onCreate : function(node, nodeSpan) {
			 // Display list of selected nodes
	        var selNodes = node.tree.getSelectedNodes();
	        // convert to title/key array
			var selKeys = $.map(selNodes, function(node) {
				if(node.data.key != '' && node.data.key.indexOf('_') != 0) {
					return node.data.key;
				}
			});
			$("#" + selectedID).val(selKeys.join(","));
		},
		// The following options are only required, if we have more than one
		// tree on one page:
		// initId: "treeData",
		cookieId : "dynatree-" + selectedID,
		idPrefix : "dynatree-" + selectedID
	});
}
