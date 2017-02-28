Imports System.Windows.Forms
Imports System.Data.SqlClient
Imports System.Text.RegularExpressions

Public Class Form1
    Implements IValidationFields

    Private Function Valideren() As Boolean _
        Implements IValidationFields.Valideren

        Dim email As New Regex("([\w-+]+(?:\.[\w-+]+)*@(?:[\w-]+\.)+[a-zA-Z]{2,7})")
        Dim creationDate As New Regex("(maandag|dinsdag|woensdag|donderdag|vrijdag)\s+\d{1,2}\s(januari|februari|maart|april|mei|juni|juli|august|september|oktober|november|december)\s\d{4}")
        Dim ErrorProvider1 As New ErrorProvider


        'If String.IsNullOrEmpty(VoornaamTextBox.Text) Then

        '    ErrorProvider1.SetError(VoornaamTextBox, "Fill in the FirstName.")

        '    Return False
        'Else

        '    ErrorProvider1.SetError(VoornaamTextBox, "")
        '    Return True

        'End If

        'If String.IsNullOrEmpty(AchternaamTextbox.Text) Then

        '    ErrorProvider1.SetError(AchternaamTextbox, "Fill in the LastName.")

        '    Return False
        'Else

        '    ErrorProvider1.SetError(AchternaamTextbox, "")
        '    Return True
        'End If

        'If String.IsNullOrEmpty(EmailTextbox.Text) Then

        '    ErrorProvider1.SetError(EmailTextbox, "Fill in the E-mail.")

        '    Return False
        'Else

        '    ErrorProvider1.SetError(EmailTextbox, "")
        '    Return True
        'End If



        'If String.IsNullOrEmpty(TelefoonTextbox.Text) Then

        '    ErrorProvider1.SetError(TelefoonTextbox, "Fill in the Phone Number.")

        '    Return False
        'Else

        '    ErrorProvider1.SetError(TelefoonTextbox, "")
        '    Return True
        'End If

        'If String.IsNullOrEmpty(OnderwerpTextBox.Text) Then

        '    ErrorProvider1.SetError(OnderwerpTextBox, "Fill in the Subject.")

        '    Return False
        'Else

        '    ErrorProvider1.SetError(OnderwerpTextBox, "")
        '    Return True
        'End If

        'If String.IsNullOrEmpty(BerichtTextBox.Text) Then

        '    ErrorProvider1.SetError(BerichtTextBox, "Fill in the message.")

        '    Return False
        'Else

        '    ErrorProvider1.SetError(BerichtTextBox, "")
        '    Return True
        'End If

        'If String.IsNullOrEmpty(IngelogdeBezoekerComboBox.Text) Then

        '    ErrorProvider1.SetError(IngelogdeBezoekerComboBox, "Fill in the missing dropdown for bezoeker.")
        '    Return False
        'Else

        '    ErrorProvider1.SetError(IngelogdeBezoekerComboBox, "")
        '    Return True
        'End If

        'If String.IsNullOrEmpty(LandComboBox.Text) Then



        '    ErrorProvider1.SetError(LandComboBox, "Fill in the country dropdown value.")

        '    Return False
        'Else

        '    ErrorProvider1.SetError(LandComboBox, "")
        '    Return True
        'End If


        If Not email.IsMatch(EmailTextbox.Text) Then

            ErrorProvider1.SetError(EmailTextbox, "Not a valid E-mail!")
            Return False

        ElseIf String.IsNullOrEmpty(EmailTextbox.Text) Then

            ErrorProvider1.SetError(EmailTextbox, "cannot have an empty E-mail!")
            Return False

        Else

            ErrorProvider1.SetError(EmailTextbox, "")
            Return True

        End If

        'If CreationDateDateTimePicker.MaxDate > Date.Today Then


        'DateTimePicker1.Format = DateTimePickerFormat.Custom
        'DateTimePicker1.CustomFormat = "yyyy/MM/dd"
        'ErrorProvider1.SetError(CreationDateDateTimePicker, "Creation Date cannot be bigger than today!!")
        'Return False
        'If Not creationDate.IsMatch(CreationDateDateTimePicker.Text) Then

        '    ErrorProvider1.SetError(CreationDateDateTimePicker, "Creation Date format is not valid!!")
        '    Return False
        'Else

        '    ErrorProvider1.SetError(CreationDateDateTimePicker, "")
        '    Return True
        'End If

        Return True

    End Function



    Private Sub Form1_Load(sender As Object, e As EventArgs) Handles MyBase.Load

        IngelogdeBezoekerComboBox.Items.Add("Ja")
        IngelogdeBezoekerComboBox.Items.Add("Nee")
        IngelogdeBezoekerComboBox.SelectedItem = IngelogdeBezoekerComboBox.Items(0)

        LandComboBox.Items.Add("België")
        LandComboBox.Items.Add("Duitsland")
        LandComboBox.Items.Add("UK")
        LandComboBox.Items.Add("Nederland")
        LandComboBox.Items.Add("Frankrijk")
        LandComboBox.Items.Add("Luxemburg")
        LandComboBox.Items.Add("Polen")
        LandComboBox.Items.Add("Ierland")

        LandComboBox.SelectedItem = LandComboBox.Items(2)


    End Sub

    Private Sub BezoekerBindingNavigatorSaveItem_Click(sender As Object, e As EventArgs) Handles BezoekerBindingNavigatorSaveItem.Click


    End Sub

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click

        Try
            If Valideren() Then


                DBModel.InsertRecord(IngelogdeBezoekerComboBox.Text, VoornaamTextBox.Text, AchternaamTextbox.Text, _
                                     EmailTextbox.Text, LandComboBox.Text, TelefoonTextbox.Text, OnderwerpTextBox.Text, _
                                     BerichtTextBox.Text, CreationDateDateTimePicker.Text)
                '
                MsgBox("Succesfully added record", MsgBoxStyle.Information)

            End If

        Catch sqlex As SqlException
            MessageBox.Show(sqlex.Message
                            )

        Catch nullpoint As NullReferenceException
            MessageBox.Show("in insert zit de nullpointer")

        End Try

    End Sub

    Private Sub Overview_Click(sender As Object, e As EventArgs) Handles Overview.Click

        Dim frm As New OverviewData

        frm.Show()

    End Sub

End Class