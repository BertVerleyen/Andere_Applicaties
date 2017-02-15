package domein;

public enum Medicamenten {
	
	ANTIDEPRESSIVA, ZALDIAR, BETHADINE, ALTHEAFLEUR, NUROFEN, PREVALIN, OTRIVIN, ; 
	
	
	public static Medicamenten case_insensitive(String s) {
		  for (Medicamenten m : Medicamenten.values()) {
		    if (m.name().equalsIgnoreCase(s)) {
		      return m;
		    }
		  }
		  return null;
		}

}
