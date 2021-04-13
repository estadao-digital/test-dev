import React from 'react'

export const required = value => 
    (value || typeof value === 'number' ? undefined : 'Requerido')

export const maxLength = max => value =>
    value && value.length > max ? `Deve ter ${max} caracteres ou menos` : undefined