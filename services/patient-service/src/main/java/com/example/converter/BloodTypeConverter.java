package com.example.converter;

import com.example.model.BloodType;

import jakarta.persistence.AttributeConverter;
import jakarta.persistence.Converter;

@Converter(autoApply = true)
public class BloodTypeConverter implements AttributeConverter<BloodType, String> {

    @Override
    public String convertToDatabaseColumn(BloodType bloodType) {
        return bloodType != null ? bloodType.getDisplayName() : null;
    }

    @Override
    public BloodType convertToEntityAttribute(String dbData) {
        return dbData != null ? BloodType.fromDisplayName(dbData) : null;
    }
}
