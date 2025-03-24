<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Step Form with Bootstrap</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-step {
            display: none;
        }
        .form-step.active {
            display: block;
        }
        .step-indicator {
            margin-bottom: 30px;
        }
        .step-indicator .step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: bold;
            margin: 0 auto;
        }
        .step-indicator .step.active {
            background-color: #0d6efd;
        }
        .step-indicator .step.completed {
            background-color: #198754;
        }
        .step-label {
            font-size: 0.8rem;
            text-align: center;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Complete Registration Form</h4>
                    </div>
                    <div class="card-body">
                        <!-- Step Indicators -->
                        <div class="row step-indicator mb-4">
                            <div class="col-3">
                                <div class="step active" id="step-indicator-1">1</div>
                                <div class="step-label">Personal Information</div>
                            </div>
                            <div class="col-3">
                                <div class="step" id="step-indicator-2">2</div>
                                <div class="step-label">Contact Details</div>
                            </div>
                            <div class="col-3">
                                <div class="step" id="step-indicator-3">3</div>
                                <div class="step-label">Professional Info</div>
                            </div>
                            <div class="col-3">
                                <div class="step" id="step-indicator-4">4</div>
                                <div class="step-label">Additional Details</div>
                            </div>
                        </div>
                        
                        <!-- Form -->
                        <form id="multiStepForm">
                            <!-- Step 1: Personal Information -->
                            <div class="form-step active" id="step-1">
                                <h5 class="mb-4">Step 1: Personal Information</h5>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="firstName" class="form-label">First Name *</label>
                                        <input type="text" class="form-control" id="firstName" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lastName" class="form-label">Last Name *</label>
                                        <input type="text" class="form-control" id="lastName" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="dob" class="form-label">Date of Birth *</label>
                                        <input type="date" class="form-control" id="dob" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="gender" class="form-label">Gender *</label>
                                        <select class="form-select" id="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                            <option value="prefer-not-to-say">Prefer not to say</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nationality" class="form-label">Nationality *</label>
                                        <input type="text" class="form-control" id="nationality" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="maritalStatus" class="form-label">Marital Status</label>
                                        <select class="form-select" id="maritalStatus">
                                            <option value="">Select Marital Status</option>
                                            <option value="single">Single</option>
                                            <option value="married">Married</option>
                                            <option value="divorced">Divorced</option>
                                            <option value="widowed">Widowed</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="passportNumber" class="form-label">Passport/ID Number</label>
                                    <input type="text" class="form-control" id="passportNumber">
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="idType" class="form-label">ID Type</label>
                                        <select class="form-select" id="idType">
                                            <option value="">Select ID Type</option>
                                            <option value="passport">Passport</option>
                                            <option value="national-id">National ID</option>
                                            <option value="drivers-license">Driver's License</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="idExpiryDate" class="form-label">ID Expiry Date</label>
                                        <input type="date" class="form-control" id="idExpiryDate">
                                    </div>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="termsAccepted">
                                    <label class="form-check-label" for="termsAccepted">
                                        I accept the terms and conditions *
                                    </label>
                                </div>
                                
                                <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn btn-primary next-step" data-step="1">Next: Contact Details</button>
                                </div>
                            </div>
                            
                            <!-- Step 2: Contact Details -->
                            <div class="form-step" id="step-2">
                                <h5 class="mb-4">Step 2: Contact Details</h5>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="confirmEmail" class="form-label">Confirm Email Address *</label>
                                    <input type="email" class="form-control" id="confirmEmail" required>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="phoneCountryCode" class="form-label">Country Code *</label>
                                        <select class="form-select" id="phoneCountryCode" required>
                                            <option value="">Select Country Code</option>
                                            <option value="+1">United States (+1)</option>
                                            <option value="+44">United Kingdom (+44)</option>
                                            <option value="+91">India (+91)</option>
                                            <option value="+61">Australia (+61)</option>
                                            <option value="+33">France (+33)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phoneNumber" class="form-label">Phone Number *</label>
                                        <input type="tel" class="form-control" id="phoneNumber" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="alternatePhone" class="form-label">Alternate Phone Number</label>
                                    <input type="tel" class="form-control" id="alternatePhone">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="streetAddress" class="form-label">Street Address *</label>
                                    <input type="text" class="form-control" id="streetAddress" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="addressLine2" class="form-label">Address Line 2</label>
                                    <input type="text" class="form-control" id="addressLine2">
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="city" class="form-label">City *</label>
                                        <input type="text" class="form-control" id="city" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="state" class="form-label">State/Province *</label>
                                        <input type="text" class="form-control" id="state" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="zipCode" class="form-label">Zip/Postal Code *</label>
                                        <input type="text" class="form-control" id="zipCode" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="country" class="form-label">Country *</label>
                                        <select class="form-select" id="country" required>
                                            <option value="">Select Country</option>
                                            <option value="us">United States</option>
                                            <option value="uk">United Kingdom</option>
                                            <option value="ca">Canada</option>
                                            <option value="au">Australia</option>
                                            <option value="in">India</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary prev-step" data-step="2">Previous: Personal Information</button>
                                    <button type="button" class="btn btn-primary next-step" data-step="2">Next: Professional Info</button>
                                </div>
                            </div>
                            
                            <!-- Step 3: Professional Information -->
                            <div class="form-step" id="step-3">
                                <h5 class="mb-4">Step 3: Professional Information</h5>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="highestEducation" class="form-label">Highest Education Level *</label>
                                        <select class="form-select" id="highestEducation" required>
                                            <option value="">Select Education Level</option>
                                            <option value="high-school">High School</option>
                                            <option value="associate">Associate's Degree</option>
                                            <option value="bachelor">Bachelor's Degree</option>
                                            <option value="master">Master's Degree</option>
                                            <option value="doctorate">Doctorate</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="fieldOfStudy" class="form-label">Field of Study *</label>
                                        <input type="text" class="form-control" id="fieldOfStudy" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="institution" class="form-label">Institution Name *</label>
                                        <input type="text" class="form-control" id="institution" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="graduationYear" class="form-label">Graduation Year *</label>
                                        <input type="number" min="1950" max="2025" class="form-control" id="graduationYear" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="currentEmployer" class="form-label">Current Employer</label>
                                    <input type="text" class="form-control" id="currentEmployer">
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="jobTitle" class="form-label">Job Title</label>
                                        <input type="text" class="form-control" id="jobTitle">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="yearsOfExperience" class="form-label">Years of Experience</label>
                                        <input type="number" min="0" max="50" class="form-control" id="yearsOfExperience">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="skills" class="form-label">Skills (comma separated)</label>
                                    <input type="text" class="form-control" id="skills">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="certifications" class="form-label">Certifications</label>
                                    <input type="text" class="form-control" id="certifications">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="languages" class="form-label">Languages Known</label>
                                    <input type="text" class="form-control" id="languages">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="linkedin" class="form-label">LinkedIn Profile URL</label>
                                    <input type="url" class="form-control" id="linkedin">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="portfolio" class="form-label">Portfolio URL</label>
                                    <input type="url" class="form-control" id="portfolio">
                                </div>
                                
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary prev-step" data-step="3">Previous: Contact Details</button>
                                    <button type="button" class="btn btn-primary next-step" data-step="3">Next: Additional Details</button>
                                </div>
                            </div>
                            
                            <!-- Step 4: Additional Details -->
                            <div class="form-step" id="step-4">
                                <h5 class="mb-4">Step 4: Additional Details</h5>
                                
                                <div class="mb-3">
                                    <label for="howDidYouHear" class="form-label">How did you hear about us?</label>
                                    <select class="form-select" id="howDidYouHear">
                                        <option value="">Select an option</option>
                                        <option value="search-engine">Search Engine</option>
                                        <option value="social-media">Social Media</option>
                                        <option value="friend">Friend/Family</option>
                                        <option value="advertisement">Advertisement</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="interestReason" class="form-label">Why are you interested?</label>
                                    <textarea class="form-control" id="interestReason" rows="2"></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="preferences" class="form-label">Preferences</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="prefersEmail">
                                        <label class="form-check-label" for="prefersEmail">Email updates</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="prefersSMS">
                                        <label class="form-check-label" for="prefersSMS">SMS notifications</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="prefersNewsletter">
                                        <label class="form-check-label" for="prefersNewsletter">Monthly newsletter</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="prefersPromo">
                                        <label class="form-check-label" for="prefersPromo">Promotional offers</label>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="availabilityDate" class="form-label">Available Start Date</label>
                                    <input type="date" class="form-control" id="availabilityDate">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="emergencyContactName" class="form-label">Emergency Contact Name</label>
                                    <input type="text" class="form-control" id="emergencyContactName">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="emergencyContactRelation" class="form-label">Relationship to Emergency Contact</label>
                                    <input type="text" class="form-control" id="emergencyContactRelation">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="emergencyContactPhone" class="form-label">Emergency Contact Phone</label>
                                    <input type="tel" class="form-control" id="emergencyContactPhone">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="additionalInfo" class="form-label">Additional Information</label>
                                    <textarea class="form-control" id="additionalInfo" rows="3"></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="dietaryRestrictions" class="form-label">Dietary Restrictions</label>
                                    <input type="text" class="form-control" id="dietaryRestrictions">
                                </div>
                                
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary prev-step" data-step="4">Previous: Professional Info</button>
                                    <button type="submit" class="btn btn-success">Submit Form</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form steps navigation
            const form = document.getElementById('multiStepForm');
            const steps = document.querySelectorAll('.form-step');
            const nextButtons = document.querySelectorAll('.next-step');
            const prevButtons = document.querySelectorAll('.prev-step');
            const stepIndicators = document.querySelectorAll('.step');
            
            // Next button click handler
            nextButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const currentStep = parseInt(this.getAttribute('data-step'));
                    const currentStepElement = document.getElementById(`step-${currentStep}`);
                    const nextStepElement = document.getElementById(`step-${currentStep + 1}`);
                    
                    // Basic validation for required fields
                    const requiredFields = currentStepElement.querySelectorAll('[required]');
                    let isValid = true;
                    
                    requiredFields.forEach(field => {
                        if (!field.value) {
                            isValid = false;
                            field.classList.add('is-invalid');
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });
                    
                    if (isValid) {
                        // Move to next step
                        currentStepElement.classList.remove('active');
                        nextStepElement.classList.add('active');
                        
                        // Update step indicators
                        document.getElementById(`step-indicator-${currentStep}`).classList.remove('active');
                        document.getElementById(`step-indicator-${currentStep}`).classList.add('completed');
                        document.getElementById(`step-indicator-${currentStep + 1}`).classList.add('active');
                        
                        // Scroll to top of form
                        window.scrollTo({ top: form.offsetTop - 50, behavior: 'smooth' });
                    }
                });
            });
            
            // Previous button click handler
            prevButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const currentStep = parseInt(this.getAttribute('data-step'));
                    const currentStepElement = document.getElementById(`step-${currentStep}`);
                    const prevStepElement = document.getElementById(`step-${currentStep - 1}`);
                    
                    // Move to previous step
                    currentStepElement.classList.remove('active');
                    prevStepElement.classList.add('active');
                    
                    // Update step indicators
                    document.getElementById(`step-indicator-${currentStep}`).classList.remove('active');
                    document.getElementById(`step-indicator-${currentStep - 1}`).classList.remove('completed');
                    document.getElementById(`step-indicator-${currentStep - 1}`).classList.add('active');
                    
                    // Scroll to top of form
                    window.scrollTo({ top: form.offsetTop - 50, behavior: 'smooth' });
                });
            });
            
            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Here you would typically collect all form data and submit it
                // For demonstration, we'll just show an alert
                alert('Form submitted successfully! Form data would be sent to the server here.');
                
                // You can collect form data with:
                // const formData = new FormData(form);
                // Or manually collect each field:
                // const data = {
                //     firstName: document.getElementById('firstName').value,
                //     ... other fields
                // };
            });
        });
    </script>
</body>
</html>