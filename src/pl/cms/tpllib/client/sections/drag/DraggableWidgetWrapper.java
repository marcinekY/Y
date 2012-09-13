package pl.cms.tpllib.client.sections.drag;

import com.google.gwt.event.dom.client.DomEvent;
import com.google.gwt.event.dom.client.HasMouseDownHandlers;
import com.google.gwt.event.dom.client.HasMouseMoveHandlers;
import com.google.gwt.event.dom.client.HasMouseUpHandlers;
import com.google.gwt.event.dom.client.MouseDownEvent;
import com.google.gwt.event.dom.client.MouseDownHandler;
import com.google.gwt.event.dom.client.MouseMoveEvent;
import com.google.gwt.event.dom.client.MouseMoveHandler;
import com.google.gwt.event.dom.client.MouseUpEvent;
import com.google.gwt.event.dom.client.MouseUpHandler;
import com.google.gwt.event.shared.HandlerRegistration;
import com.google.gwt.user.client.DOM;
import com.google.gwt.user.client.Event;
import com.google.gwt.user.client.Event.NativePreviewEvent;
import com.google.gwt.user.client.Event.NativePreviewHandler;
import com.google.gwt.user.client.ui.SimplePanel;
import com.google.gwt.user.client.ui.Widget;

public class DraggableWidgetWrapper extends SimplePanel implements
		HasMouseDownHandlers, HasMouseUpHandlers, HasMouseMoveHandlers,
		NativePreviewHandler {
	private DraggableMouseListener listener;

	public DraggableWidgetWrapper(Widget inner) {
		add(inner);
		DOM.setStyleAttribute(getElement(), "position", "absolute");
		// We don’t want to lose anything already sunk,
		// so just ORing it to what’s already there.
		DOM.sinkEvents(getElement(), DOM.getEventsSunk(getElement())
				| Event.MOUSEEVENTS);
		Event.addNativePreviewHandler(this);
		listener = new DraggableMouseListener();
		addMouseDownHandler(listener);
		addMouseUpHandler(listener);
		addMouseMoveHandler(listener);
	}

	@Override
	public void onBrowserEvent(Event event) {
		switch (DOM.eventGetType(event)) {
		case Event.ONMOUSEDOWN:
		case Event.ONMOUSEUP:
		case Event.ONMOUSEMOVE:
			DomEvent.fireNativeEvent(event, this);
			break;
		}
	}

	private class DraggableMouseListener implements MouseDownHandler,
			MouseUpHandler, MouseMoveHandler {

		private boolean dragging = false;
		private int dragStartX;
		private int dragStartY;

		@Override
		public void onMouseDown(MouseDownEvent event) {
			dragging = true;

			// capturing the mouse to the dragged widget.
			DOM.setCapture(getElement());
			dragStartX = event.getRelativeX(getElement());
			dragStartY = event.getRelativeY(getElement());
		}

		@Override
		public void onMouseUp(MouseUpEvent event) {
			dragging = false;
			DOM.releaseCapture(getElement());
		}

		@Override
		public void onMouseMove(MouseMoveEvent event) {
			if (dragging) {
				// we don’t want the widget to go off-screen, so the top/left
				// values should always remain be positive.
				int newX = Math.max(0, event.getRelativeX(getElement())
						+ getAbsoluteLeft() - dragStartX);
				int newY = Math.max(0, event.getRelativeY(getElement())
						+ getAbsoluteTop() - dragStartY);
				DOM.setStyleAttribute(getElement(), "left", "" + newX);
				DOM.setStyleAttribute(getElement(), "top", "" + newY);
			}
		}
	}

	@Override
	public HandlerRegistration addMouseDownHandler(MouseDownHandler handler) {
		return addDomHandler(handler, MouseDownEvent.getType());
	}

	@Override
	public HandlerRegistration addMouseUpHandler(MouseUpHandler handler) {
		return addDomHandler(handler, MouseUpEvent.getType());
	}

	@Override
	public HandlerRegistration addMouseMoveHandler(MouseMoveHandler handler) {
		return addDomHandler(handler, MouseMoveEvent.getType());
	}

	@Override
	public void onPreviewNativeEvent(NativePreviewEvent event) {
		Event e = Event.as(event.getNativeEvent());
		if (DOM.eventGetType(e) == Event.ONMOUSEDOWN
				&& DOM.isOrHasChild(getElement(), DOM.eventGetTarget(e))) {
			DOM.eventPreventDefault(e);
		}
	}
}