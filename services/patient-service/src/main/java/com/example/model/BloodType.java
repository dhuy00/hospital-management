package com.example.model;

public enum BloodType {
    // Using the shortest possible valid names that still make sense
    AP("A+"),
    AN("A-"),
    BP("B+"),
    BN("B-"),
    ABP("AB+"),
    ABN("AB-"),
    OP("O+"),
    ON("O-");
    
    private final String displayName;
    
    BloodType(String displayName) {
        this.displayName = displayName;
    }
    
    public String getDisplayName() {
        return displayName;
    }
    
    /**
     * Converts a display name (e.g., "O+") to the corresponding BloodType enum constant.
     * @param displayName the string representation of blood type
     * @return the corresponding BloodType enum constant
     */
    public static BloodType fromDisplayName(String displayName) {
        for (BloodType bloodType : values()) {
            if (bloodType.getDisplayName().equals(displayName)) {
                return bloodType;
            }
        }
        throw new IllegalArgumentException("No BloodType with display name: " + displayName);
    }
}
