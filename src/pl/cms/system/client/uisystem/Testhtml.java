/**
 * 
 */
package pl.cms.system.client.uisystem;

import com.google.gwt.core.client.GWT;
import com.google.gwt.dom.client.DivElement;
import com.google.gwt.dom.client.Element;
import com.google.gwt.dom.client.SpanElement;
import com.google.gwt.uibinder.client.UiBinder;
import com.google.gwt.uibinder.client.UiField;
import com.google.gwt.user.client.ui.UIObject;

/**
 * @author Y
 *
 */
public class Testhtml extends UIObject {

	private static TesthtmlUiBinder uiBinder = GWT
			.create(TesthtmlUiBinder.class);

	interface TesthtmlUiBinder extends UiBinder<Element, Testhtml> {
	}

	@UiField
	DivElement panel;
	@UiField
	SpanElement nameSpan;

	public Testhtml(String firstName) {
		setElement(uiBinder.createAndBindUi(this));

		// Can access @UiField after calling createAndBindUi
		nameSpan.setInnerText(firstName);
		
	}

}
