Imports System.Windows.Forms



Module Module1

    Sub Main()

        ''Console.WriteLine("Hello World")
        ''Console.ReadLine()

        'Dim x As Integer
        'Dim y As Integer
        'Dim str As String

        'x = 7
        'y = x + 3
        'str = "Hello hey"

        ''Console.WriteLine(y)
        ''Console.ReadLine()

        ''Console.WriteLine(str)
        ''Console.ReadLine()

        'Console.WriteLine("What's your name?")
        'Console.Write("Type your first name here: ")
        'Dim FirstName As String = Console.ReadLine()

        'Console.Write("Type your last name here: ")
        'Dim LastName As String = Console.ReadLine()

        'Console.WriteLine("Hello, " & FirstName & " " & LastName)
        'Console.ReadLine()

        'Dim message As String = ""
        'If LastName = "kieken" Then

        '    message = "hiiiiiiidiot zeker da kieken"
        '    Console.WriteLine(message)
        '    Console.ReadLine()
        'ElseIf FirstName = "Marc" Then
        '    message = "Marc vertonghen man man man kieken"
        '    Console.WriteLine(message)
        '    Console.ReadLine()
        'Else
        '    message = "ooooh oei oei just extraordinary"
        '    Console.WriteLine(message)
        '    Console.ReadLine()
        'End If

        'message = IIf(FirstName = "haha", "ok hahahaha zeker", "ok just extraordinary hoho")
        'Console.WriteLine("You are {0}", message)
        'Console.ReadLine()

        'Dim index As Integer

        'For index = 1 To 10 Step 1
        '    Console.WriteLine(index)
        '    If index = 7 Then
        '        Exit For
        '    End If
        'Next

        'Console.ReadLine()
        ''strings from 0 to 10 = 11 elements
        'Dim strings(10) As String

        'For Each item As String In strings

        '    Console.WriteLine(item & vbTab & vbNewLine)


        'Next

        'Select Case strings

        'End Select

        ''Dim collectie
        '' Dim collectielamba As String = strings.Select(Function()

        ''                                            End Function)
        'Try

        'Catch ex As Exception

        'Finally

        'End Try

        Application.EnableVisualStyles()
        Application.SetCompatibleTextRenderingDefault(False)
        Application.Run(New Form1)


    End Sub

    'Sub DisplayResult(message As String)
    '    Console.Write(message)
    '    Console.Write("REsult")


    'End Sub

    'Function GetReverseString(messages As String) As String

    '    Dim messageArray As Char() = messages.ToCharArray()
    '    Array.Reverse(messageArray)
    '    Return String.Concat(messageArray)


    'End Function

End Module
