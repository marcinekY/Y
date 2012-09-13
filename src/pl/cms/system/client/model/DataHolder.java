package pl.cms.system.client.model;

import java.util.ArrayList;

import com.google.gwt.json.client.JSONArray;
import com.google.gwt.json.client.JSONValue;




public class DataHolder {

	private ArrayList<DataEntry> dataArray = new ArrayList<DataEntry>();
	
	public DataHolder(){
	}
	
	public DataEntry getDataItem(String itemName){
		for(int i=0;i<dataArray.size();i++){
			if(dataArray.get(i).getName().equals(itemName)) {
				return dataArray.get(i);
			}
		}
		return null;
	}
	
	public JSONValue getDataValueOfItem(String itemName){
		for(int i=0;i<dataArray.size();i++){
			if(dataArray.get(i).getName().equals(itemName)) {
				JSONValue jv = dataArray.get(i).getData();
				return jv;
			}
		}
		return null;
	}
	
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
	}
	
	private boolean isExist(DataEntry de){
		for(int i=0;i<dataArray.size();i++){
			if(dataArray.get(i).equals(de)) return true;
		}
		return false;
	}
	
	/*public JSONObject getData(String name){
		for(int i=0;i<dataArray.size();i++) if(dataArray.get(i).getName().equals(name)) return dataArray.get(i).getData();
		return null;
	}*/
	

}