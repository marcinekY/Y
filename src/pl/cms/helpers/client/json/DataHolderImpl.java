package pl.cms.helpers.client.json;

import java.util.ArrayList;
import java.util.Date;

import pl.cms.helpers.client.var.Value;

import com.google.gwt.event.shared.EventBus;
import com.google.gwt.json.client.JSONArray;
import com.google.gwt.user.client.rpc.AsyncCallback;




public class DataHolderImpl implements DataHolder {
	
	private ArrayList<DataEntry> dataArray = new ArrayList<DataEntry>();
	private Jsonp server = new Jsonp();
	private EventBus eventBus;
	
	private ArrayList<Value> dataRequests = new ArrayList<Value>();
	
	public DataHolderImpl(){
	}
	
	public DataHolderImpl(EventBus eventBus){
		this.eventBus = eventBus;
	}
	
	@Override
	public void getData(String name, ActivitySetter view){
		Value value = new Value(name, view);
		dataRequests.add(value);
		DataEntry de = getData(name);
		if(de!=null){
			ActivitySetter v = (ActivitySetter)value.getValue();
			if(v!=null){
				v.setData(de);
			}
		}
	}
	
	private ActivitySetter getView(String name){
		for (int i = 0; i < dataRequests.size(); i++) {
			if(dataRequests.get(i).getName().equals(name)){
				return (ActivitySetter)dataRequests.get(i).getValue();
			}
		}
		return null;
	}
	
	@Override
	public DataEntry getData(String name){
		DataEntry de = null;
		for(int i=0;i<dataArray.size();i++){
			if(dataArray.get(i).getName().equals(name)) {
				de = dataArray.get(i);
			}
		}
		Date time = new Date();
		boolean request = false;
		if(de==null) {
			request = true;
		} else {
			if(time.getTime()-de.getLastUpdate().getTime()>7200000){ //7200000ms = 2 godziny
				request = true;
			}
		}
		if(request==true){
			request(name);
		} else {
			return de;
		}
		return null;
	}
	
//	public JSONValue getDataValueOfItem(String itemName){
//		for(int i=0;i<dataArray.size();i++){
//			if(dataArray.get(i).getName().equals(itemName)) {
//				JSONValue jv = dataArray.get(i).getData();
//				return jv;
//			}
//		}
//		return null;
//	}
	
	public void addDataItems(JSONArray j){
		for(int i=0;i<j.size();i++){
			addDataItem(new DataEntry(j.get(i).isObject()));
		}
	}
	
	public void addDataItems(ArrayList<DataEntry> itemList){
		for(int i=0;i<itemList.size();i++){
			addDataItem(itemList.get(i));
		}
	}
	
	public void addDataItem(DataEntry de){
		if(!isExist(de)) dataArray.add(de);
		fireAvtivity(de);
//		eventBus.fireEvent(new AddDataEvent(de.getName(), de));
	}
	
	public void addDataItem(String name,DataEntry de){
		if(!isExist(de)) dataArray.add(de);
		fireAvtivity(de);
//		eventBus.fireEvent(new AddDataEvent(name, de));
	}
	
	public void fireAvtivity(DataEntry data){
		ActivitySetter v = getView(data.getName());
		if(v!=null) v.setData(data);
	}
	
	public void request(String name){
		server.clearUrlVars();
		server.addVar(null, name);
		server.request(createCallback(name));
	}
	
	private AsyncCallback<JS> createCallback(final String name){
		AsyncCallback<JS> callback = new AsyncCallback<JS>() {
			@Override
			public void onSuccess(JS result) {
				DataEntry de = new DataEntry(name, result.getData(name));
				addDataItem(de);
			}
			@Override
			public void onFailure(Throwable caught) {
				request(name);
			}
		};
		return callback;
	}
	
	private boolean isExist(DataEntry de){
		for(int i=0;i<dataArray.size();i++){
			DataEntry d = dataArray.get(i);
			if(d.equals(de)) return true;
			if(d.getName().equals(de.getName())) return true;
		}
		return false;
	}

	public EventBus getEventBus() {
		return eventBus;
	}

	public void setEventBus(EventBus eventBus) {
		this.eventBus = eventBus;
	}
	
	/*public JSONObject getData(String name){
		for(int i=0;i<dataArray.size();i++) if(dataArray.get(i).getName().equals(name)) return dataArray.get(i).getData();
		return null;
	}*/
	
}