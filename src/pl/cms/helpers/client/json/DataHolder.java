package pl.cms.helpers.client.json;

public interface DataHolder {
	DataEntry getData(String name);
	void getData(String name,ActivitySetter o);
	
	public interface ActivitySetter {
		void setData(DataEntry data);
	}
}
