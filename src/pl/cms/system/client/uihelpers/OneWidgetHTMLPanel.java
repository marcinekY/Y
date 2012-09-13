package pl.cms.system.client.uihelpers;

import com.google.gwt.user.client.ui.AcceptsOneWidget;
import com.google.gwt.user.client.ui.HTMLPanel;
import com.google.gwt.user.client.ui.IsWidget;
import com.google.gwt.user.client.ui.LayoutPanel;

public class OneWidgetHTMLPanel extends HTMLPanel implements
		AcceptsOneWidget {

	public OneWidgetHTMLPanel(String html) {
		super(html);
	}

	private IsWidget widget = null;

	@Override
	public void setWidget(IsWidget w) {
		if (widget != null)
			super.remove(widget);
		widget = w;
		if (w != null)
			super.add(w);
	}

}
