package pl.cms.css.client.entry;

import java.util.ArrayList;

import com.google.gwt.dom.client.Element;
import com.google.gwt.dom.client.Style;
import com.google.gwt.user.client.DOM;
import com.google.gwt.user.client.ui.HTMLPanel;

public class StyleEntity extends Style {
	
	private String type; //hover, active, etc.
//	private ArrayList<Property> props = new ArrayList<Property>();
	
	public StyleEntity() {
		Class c = Style.class;
		Element style = DOM.createElement("style");
		
		Object[] enums = c.getEnumConstants();
		
		for (int i = 0; i < enums.length; i++) {
			
		}
		
		setTextDecoration(Style.TextDecoration.NONE);
		
		Element e = DOM.createElement("div");
		String className = CssSelector.class.getName();
		
	}
}
