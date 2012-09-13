package pl.cms.helpers.client.json;



import com.google.gwt.event.shared.GwtEvent;

public class AddDataEvent extends GwtEvent<AddDataEventHandler> {
	
	public static Type<AddDataEventHandler> TYPE = new Type<AddDataEventHandler>();
	private String name;
	private DataEntry dataEntry;

	public AddDataEvent(DataEntry dataEntry) {
		this.name = dataEntry.getName();
		this.dataEntry = dataEntry;
	}
	
	public AddDataEvent(String name, DataEntry dataEntry) {
		this.name = name;
		this.dataEntry = dataEntry;
	}
	
	public String getName(){
		return name;
	}
	
	public DataEntry getData(){
		return dataEntry;
	}

	@Override
	public Type<AddDataEventHandler> getAssociatedType() {
		return TYPE;
	}

	@Override
	protected void dispatch(AddDataEventHandler handler) {
		handler.onDataAdd(this);
	}
}
