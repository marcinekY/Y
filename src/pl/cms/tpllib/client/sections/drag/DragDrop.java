package pl.cms.tpllib.client.sections.drag;

import com.google.gwt.user.client.ui.Widget;

public class DragDrop {
	public static Widget makeDraggable(Widget widget) {
		return new DraggableWidgetWrapper(widget);
	}
}
